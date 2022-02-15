<?php

namespace Nitm\Notifications\Http\Controllers\API;

use Nitm\Api\Http\Controllers\BaseApiController;
use Illuminate\Contracts\Auth\StatefulGuard;

/**
 * @SWG\Swagger(
 *  @SWG\Info(
 *     title="Project ReadyUp API Documentation",
 *     version="1.0",
 *     description="Documentation for Project ReadyUp API. <br/><br/><h2>Global Parameters for Paginated Data:</h2>
 *       page: (integer) The current page for paginated results
 *       perPage: (integer) The number of items per page
 *       _chunk: (integer) Chunk the paginated results
 *       _fields: (string|array) Return only the specified fields
 *       _relations: (string|array) Return these relations",
 *  @SWG\Contact(
 *         email="malcolm@ninjasitm.com"
 *     )
 *   )
 * )
 * @SWG\SecurityScheme(
 *   securityDefinition="Bearer",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 * )
 */
/**
 * Api controller
 * Extend with extra functionality as needed
 *
 * @author Malcolm Paul <malcolm@ninjasitm.com>
 */
class ApiController extends BaseApiController
{
    /**
     * The guard implementation.
     *
     * @var \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected $guard;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard $guard
     * @return void
     */
    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }
}
