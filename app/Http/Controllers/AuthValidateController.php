<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Http\Domains\CreateJWTDomains;
use App\Http\Requests\Validate\OkUserRequest;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Response\ResponseCodeServices as ResponseCode;
use App\Http\Domains\EventIntercepEventsDomains as intercepEvents;



class AuthValidateController extends BaseController
{
        
    protected $events;
    protected $createJwt;

    /**
     * @param App\Http\Domains\EventIntercepEventsDomains $events
     * @param App\Http\Domains\CreateJWTDomains $createJwt
     */
    public function __construct(intercepEvents $events, CreateJWTDomains $createJwt)
    {
        $this->events = $events;
        $this->createJwt = $createJwt;
    }

    /**
     * @OA\Post(
     *     path="/V1/token/validate",
     *     description="validate",
     *     operationId="validate",
     *     tags={"Login"},
     *     summary="TOKEN-VALIDATE",
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
     *         response=200,
     *         description="{'message':'success.'}",
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


    public function __invoke(OkUserRequest $request)
    {
        try { 
            // Verify the password and generate the token
            $dataUser = Cashier::findOneId($request->getRequest()->input('auth')->cashier_id);
            if ($dataUser->exists()) {
                return ($request->getPreResponse())->main(["message" => ResponseCode::OK_MESSAGE], ResponseCode::OK);
            } else {
                return ($request->getPreResponse())->main(["message" => ResponseCode::NO_CONTENT_MESSAGE], ResponseCode::NO_CONTENT);
            }
            
        } catch (\Throwable $th) {                  
            ($this->events)($request->getRequest(), $request->getType(), ['catch' => $th->getMessage(), 'line' => $th->getLine()], __METHOD__);
            return ($request->getPreResponse())->main(['message' => ResponseCode::NO_CONTENT_MESSAGE], ResponseCode::ERROR_EXCEPTION);
        }
    }
}
