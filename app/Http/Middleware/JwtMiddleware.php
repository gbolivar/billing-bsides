<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use App\Models\Cashier;
use Firebase\JWT\ExpiredException;
use App\Services\Validator\FilterFieldsRequestServices;
use App\Services\Response\ResponseCodeServices as ResponseCode;
use App\Http\Domains\EventIntercepEventsDomains as intercepEvents;
use App\Services\Response\ReturnResponseServices as ReturnResponse;

class JwtMiddleware
{
    protected $events;

    /**
     * Events intercep
     * @param App\Http\Domains\EventIntercepEventsDomains $events
     */
    public function __construct(intercepEvents $events)
    {
        $this->events = $events;
    }


    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header()['jwt-token'][0]??null;

        // Validate is format JWT
        try {
            $codeUserRegex = config('apps.regex.tokenJWT');
            FilterFieldsRequestServices::main(['jwt-token'=>$token], [
                'jwt-token' => ['required', 'regex:/' . $codeUserRegex . '/'],
            ]);
        } catch (\Throwable $th) {
            ($this->events)($request, 'ValidateJWT', ['catch' => $th->getMessage(), 'line' => $th->getLine()], __METHOD__);
            return ReturnResponse::main((array) json_decode($th->getMessage()), ResponseCode::PRECONDITION_FAILED);
        }

        // Unauthorized response if token not there
        if (empty($token)) {
            ($this->events)($request, 'ValidateJWT', ['msg' => 'Token not provided.'], __METHOD__);
            return ReturnResponse::main(['error' => 'Token not provided.'], ResponseCode::UNAUTHORIZED);
        }

        // Validate is valids
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $th) {
            ($this->events)($request, 'ValidateJWT', ['catch' => $th->getMessage(), 'line' => $th->getLine()], __METHOD__);
            return ReturnResponse::main(['error' => 'Provided token is expired.'], ResponseCode::FORBIDDEN);
        } catch (Exception $th) {
            ($this->events)($request, 'ValidateJWT', ['catch' => $th->getMessage(), 'line' => $th->getLine()], __METHOD__);
            return ReturnResponse::main(['error' => 'An error while decoding token.'], ResponseCode::FORBIDDEN);
        }
        $user = Cashier::findOneId($credentials->sub);
        
        // check redis
        // Create token with cashier_id and tokenJWT
        $hashCheck = hash('sha256', $user->cashier_id.'-'.$token);

        $hashCheck = "JWT-$hashCheck";
        // check existe redis
        $token = ((bool) app('redis')->exists($hashCheck));
        if ($token) {
            // inject value user in request
            $request['auth'] = $user;
            return $next($request); 
        } else {
           ($this->events)($request, 'ValidateJWT', ['msg' => ResponseCode::NO_CONTENT_MESSAGE .'token JWT in Redis'], __METHOD__);
           return ReturnResponse::main(['error' => ResponseCode::NO_CONTENT_MESSAGE], ResponseCode::NO_CONTENT); 
        }        
        
    }
}
