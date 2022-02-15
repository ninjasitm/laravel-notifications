<?php

namespace Nitm\Notifications\Http\Controllers\API;

use Nitm\Notifications\Team;
use Nitm\Notifications\Http\Requests\API\CreateNotificationPreferenceAPIRequest;
use Nitm\Notifications\Http\Requests\API\UpdateNotificationPreferenceAPIRequest;
use Nitm\Notifications\Models\NotificationPreference;
use Nitm\Notifications\Repositories\NotificationPreferenceRepository;
use Nitm\Notifications\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Response;

/**
 * Class NotificationPreferenceController
 * @package App\Http\Controllers\Api
 */

class NotificationPreferenceAPIController extends ApiController
{
    /**
     * Get the repository class
     *
     * @return string
     */
    public function repository()
    {
        return NotificationPreferenceRepository::class;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notificationPreferences",
     *      summary="Get a listing of the NotificationPreferences.",
     *      tags={"NotificationPreference"},
     *      description="Get all NotificationPreferences",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/NotificationPreference")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request, Team $team)
    {
        $models = collect([]);
        $owner = $team->exists ? $team : $request->user();
        if (!$owner->notificationPreferences()->count()) {
            $owner->initNotificationPreferences();
        }

        $models = $owner->notificationPreferences();

        return $this->paginate($request, $models->sortByGroup(), 'Notification Preferences retrieved successfully');
    }

    /**
     * @param CreateNotificationPreferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notificationPreferences",
     *      summary="Store a newly created NotificationPreference in storage",
     *      tags={"NotificationPreference"},
     *      description="Store NotificationPreference",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NotificationPreference that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NotificationPreference")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/NotificationPreference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotificationPreferenceAPIRequest $request, Team $team)
    {
        $input = $request->all();

        $model = $this->getRepository()->create($input);

        return $this->printModelSuccess($model, 'Notification Preference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications/preferences/{id}",
     *      summary="Display the specified NotificationPreference",
     *      tags={"NotificationPreference"},
     *      description="Get NotificationPreference",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationPreference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/NotificationPreference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show(Request $request, Team $team, $id)
    {
        /** @var NotificationPreference $model */
        $model = $this->getRepository()->findOrFail($id);

        return $this->printModelSuccess($model, 'Notification Preference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotificationPreferenceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notifications/preferences/{id}",
     *      summary="Update the specified NotificationPreference in storage",
     *      tags={"NotificationPreference"},
     *      description="Update NotificationPreference",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationPreference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NotificationPreference that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NotificationPreference")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/NotificationPreference"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateNotificationPreferenceAPIRequest $request, Team $team, $id)
    {
        $input = $request->all();

        /** @var NotificationPreference $model */
        $this->getRepository()->existsOrFail($id);

        $model = $this->getRepository()->update($input, $id);

        return $this->printModelSuccess($model, 'NotificationPreference updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notifications/preferences/{id}",
     *      summary="Remove the specified NotificationPreference from storage",
     *      tags={"NotificationPreference"},
     *      description="Delete NotificationPreference",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationPreference",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy(Request $request, Team $team, $id)
    {
        /** @var NotificationPreference $model */
        $model = $this->getRepository()->findOrFail($id);

        return $this->printModelSuccess($model->delete(), 'Notification Preference deleted successfully');
    }
}
