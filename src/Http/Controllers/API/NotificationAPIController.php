<?php

namespace Nitm\Notifications\Http\Controllers\API;

use Response;
use Illuminate\Http\Request;
use Nitm\Content\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Nitm\Notifications\Models\Notification;
use Nitm\Notifications\Http\Controllers\API\ApiController;
use Nitm\Notifications\Repositories\NotificationRepository;
use Nitm\Notifications\Http\Requests\API\CreateNotificationAPIRequest;
use Nitm\Notifications\Http\Requests\API\UpdateNotificationAPIRequest;

/**
 * Class NotificationController
 * @package App\Http\Controllers\Api
 */

class NotificationAPIController extends ApiController
{
    /**
     * Get the repository class
     *
     * @return string
     */
    public function repository()
    {
        return NotificationRepository::class;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/api/notifications",
     *      summary="Get a listing of the Notifications.",
     *      tags={"Notification"},
     *      description="Get all Notifications",
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
     *                  @SWG\Items(ref="#/definitions/Notification")
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
            $owner->initNotifications();
        }

        $models = $owner->notificationPreferences();

        return $this->paginate($request, $models->sortByGroup(), 'Notification Preferences retrieved successfully');
    }

    /**
     * @param CreateNotificationAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/api/notifications",
     *      summary="Store a newly created Notification in storage",
     *      tags={"Notification"},
     *      description="Store Notification",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notification that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notification")
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
     *                  ref="#/definitions/Notification"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotificationAPIRequest $request, Team $team)
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
     *      summary="Display the specified Notification",
     *      tags={"Notification"},
     *      description="Get Notification",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
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
     *                  ref="#/definitions/Notification"
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
        /** @var Notification $model */
        $model = $this->getRepository()->findOrFail($id instanceof Model ? $id : ['id' => $id]);

        return $this->printModelSuccess($model, 'Notification Preference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotificationAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notifications/preferences/{id}",
     *      summary="Update the specified Notification in storage",
     *      tags={"Notification"},
     *      description="Update Notification",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Notification that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Notification")
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
     *                  ref="#/definitions/Notification"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateNotificationAPIRequest $request, Team $team, $id)
    {
        $input = $request->all();

        $model = $this->getRepository()->update($input, $id instanceof Model ? $id : ['id' => $id]);

        return $this->printModelSuccess($model, 'Notification updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notifications/preferences/{id}",
     *      summary="Remove the specified Notification from storage",
     *      tags={"Notification"},
     *      description="Delete Notification",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Notification",
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
        /** @var Notification $model */
        $model = $this->getRepository()->findOrFail($id instanceof Model ? $id : ['id' => $id]);

        return $this->printModelSuccess($model->delete(), 'Notification Preference deleted successfully');
    }
}