<?php

namespace App\Services\Jwt;

use \Firebase\JWT\JWT;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;
use App\Services\Response\ResponseCodeServices as ResponseCode;

class TokenJwtServices
{
    /**
     * Check the JWT if it meets the conditions, fits for custom and normal jwt
     * @parent String $token
     * @parent Boolean $validate, By default it is normal events by custom it is equal to false
     * @return array $array
     */
    public static function hasCkeck(String $token, $validate = true )
    {
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            $timeNext = $credentials->timeNext;
            // Check if it is jwt from normal events
            if ($validate) {
                $user = \App\Models\Subscription::findByUserIdAndServiceIdAndServiceOfferKeyAndSubscriptionId((array)$credentials);
                if (!$user) {
                    throw new \Exception(ResponseCode::UNAUTHORIZED_MESSAGE, ResponseCode::NO_CONTENT);
                } else {
                    return ['user' => $user, 'timeNext' => $timeNext];
                }
            } else{
                // Only jwt custom
                return ['data' => $credentials, 'timeNext' => $timeNext];
            }
        } catch (ExpiredException $e) {
            return ['error' => ResponseCode::UNAUTHORIZED_MESSAGE, 'code' => ResponseCode::EXIST];
        } catch (\Exception $e) {
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' => ResponseCode::ERROR_EXCEPTION];
        } catch (UnexpectedValueException $e) {
            \Log::info(__METHOD__, ['jwt' => $token, 'execption' => $e->getMessage()]);
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' => ResponseCode::NO_CONTENT];
        } catch (SignatureInvalidException $e) {
            \Log::info(__METHOD__, ['jwt' => $token, 'execption' => $e->getMessage()]);
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' => ResponseCode::NO_CONTENT];
        } catch (BeforeValidException $e) {
            \Log::info(__METHOD__, ['jwt' => $token, 'execption' => $e->getMessage()]);
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' => ResponseCode::NO_CONTENT];
        } catch (InvalidArgumentException $e) {
            \Log::info(__METHOD__, ['jwt' => $token, 'execption' => $e->getMessage()]);
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' => ResponseCode::NO_CONTENT];
        } catch (DomainException $e) {
            \Log::info(__METHOD__, ['jwt' => $token, 'execption' => $e->getMessage()]);
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' =>  ResponseCode::NO_CONTENT];
        } catch (RequestException $e) {
            \Log::info(__METHOD__, ['jwt' => $token, 'execption' => $e->getMessage()]);
            return ['error' => ResponseCode::PRECONDITION_FAILED_MESSAGE, 'code' => ResponseCode::NO_CONTENT];
        }
    }
}
