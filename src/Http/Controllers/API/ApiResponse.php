<?php

/**
 * Class ApiResponse
 *
 * @package App
 *
 * @author Malcolm Paul <malcolm@ninjasitm.com>
 */

/**
 * @OA\Response(
 *    response="BooleanResult",
 *    description="Successful Response",
 *    @OA\JsonContent(
 *      @OA\Property(property="status", type="string", example="ok"),
 *      @OA\Property(property="data",   type="string", example="true"),
 *    )
 * )
 */

/**
 * @OA\Response(
 *    response="200 (single)",
 *    description="Successful Response",
 *    @OA\JsonContent(ref="#/components/schemas/200Single")
 * )
 */

/**
 * @OA\Schema(
 *      schema="200Single",
 *      @OA\Property(property="status", type="string", example="ok"),
 *      @OA\Property(property="data",   type="object")
 *   )
 */

/**
 * @OA\Response(
 *    response="200 (collection)",
 *    description="Successful Collection Response",
 *    @OA\JsonContent(ref="#/components/schemas/200Collection")
 * )
 */

/**
 * @OA\Schema(
 *      schema="200Collection",
 *      @OA\Property(property="status",         type="string", example="ok"),
 *      @OA\Property(
 *          property="data",
 *          type="object",
 *      @OA\Property(property="current_page",   type="integer", example="1"),
 *      @OA\Property(property="first_page_url", type="string", example="/?page=1"),
 *      @OA\Property(property="from",           type="integer", example="1"),
 *      @OA\Property(property="last_page",      type="integer", example="1"),
 *      @OA\Property(property="last_page_url",  type="string", example="/?page=1"),
 *      @OA\Property(property="next_page_url",  type="string", example="null"),
 *      @OA\Property(property="path",           type="string", example="/"),
 *      @OA\Property(property="per_page",       type="integer", example="10"),
 *      @OA\Property(property="prev_page_url",  type="string", example="null"),
 *      @OA\Property(property="to",             type="integer", example="8"),
 *      @OA\Property(property="total",          type="integer", example="8")
 *      )
 *   )
 */

/**
 * @OA\Response(
 *    response="500 Server Error",
 *    description="Internal Server Error",
 *    @OA\Schema(
 *          properties={
 *      @OA\Property(property="status", type="string", example="error"),
 *      @OA\Property(property="data",   type="string", example="Internal Server Error")
 *          }
 *     )
 * )
 */

/**
 * @OA\Response(
 *    response="403 Forbidden",
 *    description="Forbidden",
 *    @OA\JsonContent(
 *          properties={
 *      @OA\Property(property="status", type="string", example="error"),
 *      @OA\Property(property="data",   type="string", example="Forbidden")
 *          }
 *     )
 * )
 */

/**
 * @OA\Response(
 *    response="404 Not Found",
 *    description="Not Found",
 *    @OA\JsonContent(
 *          properties={
 *      @OA\Property(property="status", type="string", example="error"),
 *      @OA\Property(property="data",   type="string", example="Not found")
 *          }
 *     )
 * )
 */

/**
 * @OA\Response(
 *    response="422 Invalid",
 *    description="Invalid Data Provided",
 *    @OA\JsonContent(
 *      properties={
 *      @OA\Property(property="status",  type="string", example="error"),
 *      @OA\Property(property="message", type="string", example="[Validation field error]"),
 *      @OA\Property(
 *                  property="data",
 *                  type="object",
 *                  @OA\Schema(
 *                      properties={
 *                      @OA\Property(
 *                              property="{invalid_field}",
 *                              @OA\Schema(
 *                                  properties={
 *                                  @OA\Property(property="0", type="string", example="This field is invalid")
 *                                  }
 *                              )
 *                          )
 *                      }
 *                  )
 *              )
 *          }
 *     )
 * )
 */