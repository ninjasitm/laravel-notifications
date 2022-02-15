<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Nitm\Notifications\Models\CommunicationToken;
use Nitm\Notifications\Notifications\FcmFunctionChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Nitm\Notifications\Listeners\BaseNotifyOfActivity;

class NotificationsTest extends TestCase
{
    protected $usesTeams = true;

    // public function testNotify()
    // {
    //     $user = $this->useAsUser();
    //     $admin = $this->useAsAdmin();
    //     $this->addCommunicationTokens($user);
    //     $this->addCommunicationTokens($admin);
    //     foreach ($this->getNotifications() as $notificationClass => $options) {
    //         Notification::fake();
    //         extract($options);
    //         $listener = new $listenerClass();
    //         $notification = $this->prepareNotification($notificationClass, $options);
    //         $target = Arr::get($options, 'forAdmin') ? $admin : $user;
    //         $result = Notification::send([$target], $notification);
    //         foreach ($notification->via($target) as $channel) {
    //             if (Arr::get($options, 'forAdmin') && ($listener->getAdminNotificationClass())) {
    //                 Notification::assertSentTo(
    //                     [$admin],
    //                     $notificationClass
    //                 );
    //             }

    //             if (!Arr::get($options, 'forAdmin') && ($listener->getNotificationClass())) {
    //                 Notification::assertSentTo(
    //                     [$user],
    //                     $notificationClass
    //                 );
    //             }
    //         }
    //     }
    // }

    // public function testFcmFunctionChannel()
    // {
    //     $user = $this->useAsUser();
    //     $admin = $this->useAsAdmin();
    //     $this->addCommunicationTokens($user);
    //     $this->addCommunicationTokens($admin);
    //     $channel = new FcmFunctionChannel();
    //     foreach ($this->getNotifications() as $notificationClass => $options) {
    //         extract($options);
    //         $notification = $this->prepareNotification($notificationClass, $options);
    //         $target = Arr::get($options, 'forAdmin') ? $admin : $user;
    //         $result = $channel->send(
    //             $target,
    //             $notification
    //         );
    //         $this->assertTrue($result !== false);
    //     }
    // }

    // public function testNotifyByFirebase()
    // {
    //     $user = $this->useAsUser();
    //     $admin = $this->useAsAdmin();
    //     $this->addCommunicationTokens($user);
    //     $this->addCommunicationTokens($admin);
    //     $class = \App\Notifications\NotifyOfNewFeedNotificationByFirebase::class;
    //     $manager = app(ChannelManager::class);
    //     foreach ($this->getNotifications() as $notificationClass => $options) {
    //         $faker = Notification::fake();
    //         extract($options);
    //         $listener = new $listenerClass();
    //         $model = $this->prepareModel($options);
    //         $event = $this->prepareEvent($options, $model);
    //         $data = $this->prepare($listener, $event);
    //         $notification = $this->prepareNotification($notificationClass, $options);
    //         $target = Arr::get($options, 'forAdmin') ? $admin : $user;
    //         $expectedData = $listener->getData($event);
    //         foreach ($notification->via($target) as $channel) {
    //             $result = $manager->channel($channel)->send($target, $notification);
    //             if (is_array($result)) {
    //                 $result = Arr::get($result, 'data', $result);
    //                 foreach ($expectedData as $key => $value) {
    //                     $this->assertArrayHasKey($key, $result, "No [$key] for $listenerClass on channel: {$channel} \n" . json_encode($expectedData, JSON_PRETTY_PRINT) . "\n" . json_encode($result, JSON_PRETTY_PRINT));
    //                 }
    //             }
    //             $sent = $faker->send($target, $notification);
    //             Notification::assertSentTo(
    //                 [$target],
    //                 $notificationClass
    //             );
    //         }
    //     }
    // }

    // public function testNotifyByFirebaseViaFacade()
    // {
    //     $user = $this->useAsUser();
    //     $admin = $this->useAsAdmin();
    //     $this->addCommunicationTokens($user);
    //     $this->addCommunicationTokens($admin);
    //     $class = \App\Notifications\NotifyOfNewFeedNotificationByFirebase::class;
    //     foreach ($this->getNotifications() as $notificationClass => $options) {
    //         Notification::fake();
    //         extract($options);
    //         $model = $this->prepareModel($options);
    //         $event = $this->prepareEvent($options, $model);
    //         $data = $this->prepare(new $listenerClass(), $event);
    //         $target = Arr::get($options, 'forAdmin') ? $admin : $user;
    //         $result = Notification::send([$target], new $class($data));
    //         Notification::assertSentTo(
    //             [$target],
    //             $class
    //         );
    //     }
    // }

    // /**
    //  * Add Communication Tokens
    //  *
    //  * @param  mixed $user
    //  * @param  mixed $type
    //  * @param  mixed $count
    //  * @return void
    //  */
    // protected function addCommunicationTokens($user, $type = 'fcm', $count = 1)
    // {
    //     $user->communicationTokens()
    //         ->saveMany(
    //             CommunicationToken::factory($count)
    //                 ->make()
    //                 ->map(function ($token) use ($type) {
    //                     $token->type = $type;
    //                     return $token;
    //                 })
    //         );
    // }

    // /**
    //  * Prepare the event data
    //  *
    //  * @param  mixed $event
    //  * @return array
    //  */
    // protected function prepare($listener, $event): array
    // {
    //     $data = array_filter($listener->getData($event));
    //     $data = array_merge([
    //         'icon' => 'new_releases',
    //         'type' => Str::slug(Str::snake(class_basename(get_class($event)))),
    //         'body' => BaseNotifyOfActivity::prepareMessage($listener->getMessage($event), $data)
    //     ],  $data);
    //     return $data;
    // }

    // /**
    //  * Prepare Event
    //  *
    //  * @param  mixed $options
    //  * @return void
    //  */
    // protected function prepareEvent($options, $model = null)
    // {
    //     $model = $model ?: $this->prepareModel($options);
    //     return isset($options['event']) ? $options['event']($model) : new $options['eventClass']($model);
    // }

    // /**
    //  * Prepare Model
    //  *
    //  * @param  mixed $options
    //  * @return void
    //  */
    // protected function prepareModel($options)
    // {
    //     return isset($options['model']) ? $options['model']() : $options['modelClass']::factory()->create();
    // }

    // /**
    //  * Prepare a single Notification
    //  *
    //  * @param string $notificationClass
    //  * @param  mixed $options
    //  * @return mixed
    //  */
    // protected function prepareNotification($notificationClass, $options)
    // {
    //     $listener = new $options['listenerClass']();
    //     $model = $this->prepareModel($options);
    //     $event = $this->prepareEvent($options, $model);
    //     $data = $this->prepare($listener, $event);
    //     $data = isset($options['data']) ? $options['data']($model) : [
    //         $listener->getActionText($event),
    //         $listener->getMessage($event),
    //         $listener->getActionUrl($event)
    //     ];
    //     return (new $notificationClass(...$data))->setData(['data' => $listener->getData($event)]);
    // }

    // protected function getNotifications(): array
    // {
    //     return [
    //         \App\Notifications\NewComment::class => [
    //             'listenerClass' => \Nitm\Notifications\Listeners\FeedNotificationWasReceived::class,
    //             'modelClass' => \Nitm\Notifications\Models\Notification::class,
    //             'eventClass' => \Nitm\Notifications\Events\FeedNotificationWasReceived::class,
    //         ],
    //     ];
    // }
}