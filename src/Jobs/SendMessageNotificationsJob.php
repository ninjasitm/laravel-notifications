<?php

namespace Nitm\Notifications\Jobs;

use Nitm\Notifications\Models\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Nitm\Notifications\Models\ChatMessage;
use Illuminate\Bus\Queueable;
use Laravel\Spark\Notification;
use Nitm\Notifications\Events\ChatMessageWasReceived;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Nitm\Notifications\Notifications\NotifyOfNewChatMessage;
use Laravel\Spark\Events\NotificationCreated;
use Nitm\Notifications\Notifications\NotifyOfNewChatMessageByEmail;
use Nitm\Notifications\Notifications\NotifyOfNewChatMessageByFirebase;

class SendMessageNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The message
     *
     * @var ChatMessage
     */
    public $message;

    /**
     * The authenticated user
     *
     * @var User
     */
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ChatMessage $message, User $user)
    {
        $this->message = $message->withoutRelations();
        $this->user = $user->withoutRelations();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->message->load(['to', 'thread.group']);
            /**
             * If the receiving user is not active in the period specified then send them a message
             */
            $threshold = Carbon::now()->sub(15, 'minutes');
            $messageUrl = '/app/chat/' . $this->message->thread_id . '#message' . $this->message->id;
            if ($this->message->thread->isGroup) {
                $this->message->thread->load('group');
                if (
                    !$this->message->thread->group
                    || $this->message->thread->group
                    && !$this->message->thread->group->members()->count()
                ) {
                    return;
                }
                $members = $this->message->thread->group
                    ->members(function ($query) {
                        $query->where('id', '!=', $this->message->user_id);
                    })
                    ->with([
                        'notificationPreferences' => function ($query) {
                            $query->enabled()->preferencesFor([\App\Listeners\ChatMessageWasReceived::class]);
                        }
                    ])
                    ->get()
                    ->filter(function ($user) {
                        return $user->id != $this->message->user_id && $user->notificationsAreActive();
                    })
                    ->concat([$this->message->to])
                    ->filter()
                    ->unique('id');
                if ($members->count()) {
                    logger()->info(
                        "Chat: [" . $this->message->thread_id . "] Preparing to send notifications to [" . $members->count() . "] participants",
                        ['users' => $members->pluck('email')->all()]
                    );
                    $forEmail = $members->filter(
                        function ($user) use ($threshold) {
                            $userThreshold = $user->timezone ? $threshold->clone()->setTimezone($user->timezone) : $threshold;
                            return (!$user->last_active || Carbon::parse($user->last_active)->isBefore($userThreshold)) &&
                                $user->hasEnabledNotificationPreferenceVia(\App\Listeners\ChatMessageWasReceived::class, 'email');
                        }
                    );
                    if ($forEmail->count()) {
                        logger()->info(
                            "Chat: [" . $this->message->thread_id . "] Sending email notifications to [" . $forEmail->count() . "] participants who have been inactive since (GMT) {$threshold}",
                            ["users" => $forEmail->pluck('email')->all()]
                        );
                        $forEmail->map(function ($member) use ($messageUrl) {
                            $member->notify(
                                new NotifyOfNewChatMessageByEmail(
                                    ' chat ' . $this->message->thread->title,
                                    $this->message,
                                    $messageUrl
                                )
                            );
                        });
                    }

                    $forMobile = $members->filter(function ($user) {
                        return $user->hasEnabledNotificationPreferenceVia(\App\Listeners\ChatMessageWasReceived::class, 'mobile');
                    });

                    if ($forMobile->count()) {
                        logger()->info(
                            "Chat: [" . $this->message->thread_id . "] Sending mobile notifications to [" . $forMobile->count() . "] participants",
                            ["users" => $forMobile->pluck('email')->all()]
                        );
                        $forMobile->map(function ($member) use ($messageUrl) {
                            $member->notify(
                                new NotifyOfNewChatMessageByFirebase(
                                    ' chat ' . $this->message->thread->title,
                                    $this->message,
                                    $messageUrl
                                )
                            );
                        });
                    }
                }
            } else {
                $this->message->load('to');
                $to = $this->message->isCreatedBy($this->user) ? $this->message->to : $this->message->user;
                $notification = Notification::create([
                    'id' => Uuid::uuid4(),
                    'user_id' => $to->id,
                    'created_by' => $this->message->user_id,
                    'icon' => 'chat',
                    'body' => 'New message from ' . $this->user->name,
                    'action_text' => 'View Message',
                    'action_url' => $messageUrl,
                ]);

                event(new NotificationCreated($notification));

                if (
                    (!$to->last_active
                        || Carbon::parse($to->last_active)->isBefore($threshold))
                    && $to->hasEnabledNotificationPreferenceVia(\App\Listeners\ChatMessageWasReceived::class, 'email')
                ) {
                    $to->notify(
                        new NotifyOfNewChatMessageByEmail(
                            ' chat with ' . $this->user->name,
                            $this->message,
                            $messageUrl
                        )
                    );
                }
                if ($to->hasEnabledNotificationPreferenceVia(\App\Listeners\ChatMessageWasReceived::class, 'mobile')) {
                    $to->notify(
                        new NotifyOfNewChatMessageByFirebase(
                            ' chat with ' . $this->user->name,
                            $this->message,
                            $messageUrl
                        )
                    );
                }
            }
        } catch (\Exception $e) {
            // throw $e;
            logger()->error($e);
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function failed(\Exception $e)
    {
        logger()->error($e);
    }
}
