<?php

namespace Nitm\Notifications\Http\Controllers\API;

use Response;
use Illuminate\Http\Request;
use Nitm\Content\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Nitm\Notifications\Models\Announcement;
use Nitm\Notifications\Http\Controllers\API\ApiController;
use Nitm\Notifications\Repositories\AnnouncementRepository;
use Nitm\Notifications\Http\Requests\API\CreateAnnouncementAPIRequest;
use Nitm\Notifications\Http\Requests\API\UpdateAnnouncementAPIRequest;

/**
 * Class AnnouncementController
 * @package App\Http\Controllers\Api
 */

class AnnouncementAPIController extends ApiController
{
    /**
     * Get the repository class
     *
     * @return string
     */
    public function repository()
    {
        return AnnouncementRepository::class;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notificationPreferences",
     *      summary="Get a listing of the Announcements.",
     *      tags={"Announcement"},
     *      description="Get all Announcements",
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
     *                  @SWG\Items(ref="#/definitions/Announcement")
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
            $owner->initAnnouncements();
        }

        $models = $owner->notificationPreferences();

        return $this->paginate($request, $models->sortByGroup(), 'Announcement Preferences retrieved successfully');
    }

    /**
     * @param CreateAnnouncementAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notificationPreferences",
     *      summary="Store a newly created Announcement in storage",
     *      tags={"Announcement"},
     *      description="Store Announcement",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Announcement that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Announcement")
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
     *                  ref="#/definitions/Announcement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAnnouncementAPIRequest $request, Team $team)
    {
        $input = $request->all();

        $model = $this->getRepository()->create($input);

        return $this->printModelSuccess($model, 'Announcement Preference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications/preferences/{id}",
     *      summary="Display the specified Announcement",
     *      tags={"Announcement"},
     *      description="Get Announcement",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Announcement",
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
     *                  ref="#/definitions/Announcement"
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
        /** @var Announcement $model */
        $model = $this->getRepository()->findOrFail($id instanceof Model ? $id : ['id' => $id]);

        return $this->printModelSuccess($model, 'Announcement Preference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAnnouncementAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notifications/preferences/{id}",
     *      summary="Update the specified Announcement in storage",
     *      tags={"Announcement"},
     *      description="Update Announcement",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Announcement",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Announcement that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Announcement")
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
     *                  ref="#/definitions/Announcement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateAnnouncementAPIRequest $request, Team $team, $id)
    {
        $input = $request->all();

        $model = $this->getRepository()->update($input, $id instanceof Model ? $id : ['id' => $id]);

        return $this->printModelSuccess($model, 'Announcement updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notifications/preferences/{id}",
     *      summary="Remove the specified Announcement from storage",
     *      tags={"Announcement"},
     *      description="Delete Announcement",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Announcement",
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
        /** @var Announcement $model */
        $model = $this->getRepository()->findOrFail($id instanceof Model ? $id : ['id' => $id]);

        return $this->printModelSuccess($model->delete(), 'Announcement Preference deleted successfully');
    }
}