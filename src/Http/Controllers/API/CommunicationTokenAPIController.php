<?php

namespace Nitm\Notifications\Http\Controllers\API;

use Nitm\Content\Models\Team;
use Nitm\Notifications\Http\Requests\API\CreateCommunicationTokenAPIRequest;
use Nitm\Notifications\Http\Requests\API\UpdateCommunicationTokenAPIRequest;
use Nitm\Notifications\Models\CommunicationToken;
use Nitm\Notifications\Repositories\CommunicationTokenRepository;
use Nitm\Notifications\Http\Controllers\API\ApiController;
use Illuminate\Http\Request;
use Response;

/**
 * Class CommunicationTokenController
 * @package App\Http\Controllers\Api
 */

class CommunicationTokenAPIController extends ApiController
{
    /**
     * Get the repository class
     *
     * @return string
     */
    public function repository()
    {
        return CommunicationTokenRepository::class;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications/communication-tokens",
     *      summary="Get a listing of the CommunicationTokens.",
     *      tags={"CommunicationToken"},
     *      description="Get all CommunicationTokens",
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
     *                  @SWG\Items(ref="#/definitions/CommunicationToken")
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
        $models = $request->user()->communicationTokens();

        return $this->paginate($request, $models, 'CommunicationToken Preferences retrieved successfully');
    }

    /**
     * @param CreateCommunicationTokenAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/notifications/communication-tokens",
     *      summary="Store a newly created CommunicationToken in storage",
     *      tags={"CommunicationToken"},
     *      description="Store CommunicationToken",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CommunicationToken that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CommunicationToken")
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
     *                  ref="#/definitions/CommunicationToken"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCommunicationTokenAPIRequest $request, Team $team)
    {
        $input = $request->all();

        $model = $this->getRepository()->create($input);

        return $this->printModelSuccess($model, 'CommunicationToken Preference saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/notifications/communication-tokens/{id}",
     *      summary="Display the specified CommunicationToken",
     *      tags={"CommunicationToken"},
     *      description="Get CommunicationToken",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommunicationToken",
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
     *                  ref="#/definitions/CommunicationToken"
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
        /** @var CommunicationToken $model */
        $model = $this->getRepository()->findOrFail($id);

        return $this->printModelSuccess($model, 'CommunicationToken Preference retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCommunicationTokenAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/notifications/communication-tokens/{id}",
     *      summary="Update the specified CommunicationToken in storage",
     *      tags={"CommunicationToken"},
     *      description="Update CommunicationToken",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommunicationToken",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CommunicationToken that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CommunicationToken")
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
     *                  ref="#/definitions/CommunicationToken"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(UpdateCommunicationTokenAPIRequest $request, Team $team, $id)
    {
        $input = $request->all();

        /** @var CommunicationToken $model */
        $this->getRepository()->existsOrFail($id);

        $model = $this->getRepository()->update($input, $id);

        return $this->printModelSuccess($model, 'CommunicationToken updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/notifications/communication-tokens/{id}",
     *      summary="Remove the specified CommunicationToken from storage",
     *      tags={"CommunicationToken"},
     *      description="Delete CommunicationToken",
     *      produces={"application/json"},
     *      security={{"Bearer":{}}},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CommunicationToken",
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
        /** @var CommunicationToken $model */
        $model = $this->getRepository()->findOrFail($id);

        return $this->printModelSuccess($model->delete(), 'CommunicationToken Preference deleted successfully');
    }
}