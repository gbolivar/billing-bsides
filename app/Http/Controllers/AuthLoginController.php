<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Http\Domains\CreateJWTDomains;
use App\Http\Requests\Validate\LoginUserRequest;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Response\ResponseCodeServices as ResponseCode;
use App\Http\Domains\EventIntercepEventsDomains as intercepEvents;

class AuthLoginController extends BaseController
{
    
    
    protected $events;
    protected $createJwt;

    /**
     * 
     */
    public function __construct(intercepEvents $events, CreateJWTDomains $createJwt)
    {
        $this->events = $events;
        $this->createJwt = $createJwt;
    }

    /**
     * @OA\Post(
     *     path="/V1/login",
     *     description="login app with login and passowd",
     *     operationId="login",
     *     tags={"Login"},
     *     summary="LOGIN",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                @OA\Property(
     *                     property="login",
     *                     type="date"
     *                 ),
     *                @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"login":"users", "password":"key"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="{'message':'The item was created successfully.'}",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"message":"The item was created successfully."}
     *              )
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="{'message':'The server did not find the registry.'}",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"message":"The server did not find the registry."}
     *              )
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="{'message':'The server did not find the registry.'}",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"message":"Validation errors in your request."}
     *              )
     *     )
     * )
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __invoke(loginUserRequest $request)
    {
        try { 
            // Verify the password and generate the token
            $dataUser = Cashier::findOneLogin($request->getRequest()->all());
            if ($dataUser->exists()) {
                return ($request->getPreResponse())->main([
                    "message" => ResponseCode::CREATED_MESSAGE,
                    'username' => $dataUser->toArray()["full_name"],
                    'access_token' => (($this->createJwt)($dataUser, env('JWT_EXPIRE')))
                ], ResponseCode::CREATED);
            } else {
                return ($request->getPreResponse())->main(["message" => ResponseCode::NO_CONTENT_MESSAGE], ResponseCode::NO_CONTENT);
            }
            
        } catch (\Throwable $th) {                  
            ($this->events)($request->getRequest(), $request->getType(), ['catch' => $th->getMessage(), 'line' => $th->getLine()], __METHOD__);
            return ($request->getPreResponse())->main(['message' => ResponseCode::NO_CONTENT_MESSAGE], ResponseCode::ERROR_EXCEPTION);
        }
    }
}
