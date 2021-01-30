<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Http\Domains\CreateJWTDomains;
use App\Http\Requests\Validate\RefreshUserRequest;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Response\ResponseCodeServices as ResponseCode;
use App\Http\Domains\EventIntercepEventsDomains as intercepEvents;


class AuthRefreshController extends BaseController
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
     *     path="/v1/token/refresh",
     *     description="refresh token jwt",
     *     operationId="refresh",
     *     tags={"Login"},
     *     summary="TOKEN-REFRESH",
     *     security={{"bearer":{}}},
     *     @OA\Parameter(
     *         name="token",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             @OA\Items(type="string"),
     *         ),
     *         style="form",
     *         example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJpcm9uY29yZS1qd3QiLCJzdWIiOjUsImlhdCI6MTU4MDAwODg2OSwiZXhwIjoxNTgwMDEyNDY5fQ.NZoTefzgmhl-1wq1nSxfBS_-vUPIFjRPNiUwynQIjYM"
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="{'message':'The item was created successfully.'}",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="{'message':'Malformed request, required for header: authorization, x-transaction-id, requestaudit.'}",
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="{'message':'Unauthorized required Bearer Token.'}",
     *     )
     * )
     */



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __invoke(RefreshUserRequest $request)
    {
        try { 
            // Verify the password and generate the token
            $dataUser = Cashier::findOneId($request->getRequest()->input('auth')->cashier_id);
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
