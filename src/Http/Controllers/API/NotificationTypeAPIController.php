<?php

namespace Nitm\Notifications\Http\Controllers\API;

use Nitm\Notifications\Team;
use Nitm\Notifications\Http\Requests\API\CreateNotificationTypeAPIRequest;
use Nitm\Notifications\Http\Requests\API\UpdateNotificationTypeAPIRequest;
use Nitm\Notifications\Models\NotificationType;
use Nitm\Notifications\Repositories\NotificationTypeRepository;
use Nitm\Notifications\Http\Controllers\BaseControllers\CustomController;
use Illuminate\Http\Request;
use Response;

/**
 * Class NotificationTypeController
 * @package App\Http\Controllers\Api
 */

class NotificationTypeAPIController extends CustomController
{
    /**
     * Get the repository class
     *
     * @return string
     */
    public function repository()
    {
        return NotificationTypeRepository::class;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notificationTypes",
     *      summary="Get a listing of the NotificationTypes.",
     *      tags={"NotificationType"},
     *      description="Get all NotificationTypes",
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
     *                  @SWG\Items(ref="#/definitions/NotificationType")
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
        $models = $this->getRepository()->search($request->all());

        return $this->paginate($request, $models, 'Notification Types retrieved successfully');
    }

    /**
     * @param CreateNotificationTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notificationTypes",
     *      summary="Store a newly created NotificationType in storage",
     *      tags={"NotificationType"},
     *      description="Store NotificationType",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NotificationType that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NotificationType")
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
     *                  ref="#/definitions/NotificationType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateNotificationTypeAPIRequest $request, Team $team)
    {
        $input = $request->all();

        $model = $this->getRepository()->create($input);

        return $this->printModelSuccess($model, 'Notification Type saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notificationTypes/{id}",
     *      summary="Display the specified NotificationType",
     *      tags={"NotificationType"},
     *      description="Get NotificationType",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationType",
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
     *                  ref="#/definitions/NotificationType"
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
        /** @var NotificationType $model */
        $model = $this->getRepository()->findOrFail($id);

        return $this->printModelSuccess($model, 'Notification Type retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateNotificationTypeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notificationTypes/{id}",
     *      summary="Update the specified NotificationType in storage",
     *      tags={"NotificationType"},
     *      description="Update NotificationType",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationType",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="NotificationType that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/NotificationType")
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
     *                  ref="#/definitions/NotificationType"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateNotificationTypeAPIRequest $request, Team $team, $id)
    {
        $input = $request->all();

        /** @var NotificationType $model */
        $this->getRepository()->existsOrFail($id);

        $model = $this->getRepository()->update($input, $id);

        return $this->printModelSuccess($model, 'NotificationType updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notificationTypes/{id}",
     *      summary="Remove the specified NotificationType from storage",
     *      tags={"NotificationType"},
     *      description="Delete NotificationType",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of NotificationType",
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
        /** @var NotificationType $model */
        $model = $this->getRepository()->findOrFail($id);

        return $this->printModelSuccess($model->delete(), 'Notification Type deleted successfully');
    }
}
