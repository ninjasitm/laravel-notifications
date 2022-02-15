<?php

/**
 * Class ApiQueryParams
 *
 * @package App
 *
 * @author Malcolm Paul <malcolm@ninjasitm.com>
 */

/**
 *
 * @OA\Parameter(
 *     name="_chunk",
 *     in="query",
 *     description="Chunk the results",
 *     required=false
 *     @OA\Schema(
 *          type="integer",
 *          default=1,
 *      )
 * ),
 */

/**
 *
 * @OA\Parameter(
 *     name="page",
 *     in="query",
 *     description="Get the specified page",
 *     required=false
 *     @OA\Schema(
 *          type="integer",
 *          default=1,
 *      )
 * ),
 */

/**
 *
 * @OA\Parameter(
 *     name="perPage",
 *     in="query",
 *     description="Get the specified number of records per page",
 *     required=false
 *     @OA\Schema(
 *          type="integer",
 *          default=10,
 *      )
 * ),
 */

/**
 *
 * @OA\Parameter(
 *     name="_fields",
 *     in="query",
 *     description="Get only the specified fields",
 *     required=false
 * ),
 */

/**
 *
 * @OA\Parameter(
 *     name="_relations",
 *     in="query",
 *     description="Get only the specified relations",
 *     required=false
 * ),
 */