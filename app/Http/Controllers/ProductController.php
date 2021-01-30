<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Domains\CreateJWTDomains;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Services\Response\ResponseCodeServices as ResponseCode;
use App\Http\Domains\EventIntercepEventsDomains as intercepEvents;
use App\Services\Response\ReturnResponseServices as ReturnResponse;


class ProductController extends BaseController
{
        
    protected $events;

    /**
     * @param App\Http\Domains\EventIntercepEventsDomains $events
     */
    public function __construct(intercepEvents $events, CreateJWTDomains $createJwt)
    {
        $this->events = $events;
    }

    /**
     * @OA\Post(
     *     path="/V1/product/list",
     *     description="List of products ",
     *     operationId="listProducts",
     *     tags={"Product"},
     *     summary="TOKEN-VALIDATE",
     *     security={{"bearer":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Sucess",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="items",
     *                     type="json",
     *                 ),
     *                 example={"message":"Sucess", "items":"[]"})
     *     ),

     *     @OA\Response(
     *         response=409,
     *         description="{'message':'Validation errors in your request.'}",
     *         @OA\JsonContent(
     *              @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"message":"Validation errors in your request."}
     *              )
     *     ),
     * )
     */


    public function __invoke(Request $request)
    {
        try { 
            // Verify the password and generate the token
            $list = Product::all();
        
            return ReturnResponse::main([
                "message" => ResponseCode::OK,
                'items' => $list->toArray()
            ], ResponseCode::OK);
            
            
        } catch (\Throwable $th) {                  
            ($this->events)($request, 'ListProduct', ['catch' => $th->getMessage(), 'line' => $th->getLine()], __METHOD__);
            return ReturnResponse::main(['message' => ResponseCode::NO_CONTENT_MESSAGE], ResponseCode::ERROR_EXCEPTION);
        }
    }
}
