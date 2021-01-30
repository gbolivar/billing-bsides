<?php 

namespace App\Services\Response;

use Illuminate\Http\Response;
use App\Services\Response\SendSqsResponseServices;
use App\Services\Logger\LoggerEventsServices;

class ReturnResponseServices extends Response
{

    public static function main(Array $options, Int $code, $notify = true)
    {

    	// Logger local Response
        (new LoggerEventsServices)('info', __METHOD__, ['Response' => $options, 'code'=> $code]);

		// Return Response
        return response()->json($options, $code);
    }
}
