<?php 
namespace App\Http\Domains;

use Firebase\JWT\JWT;
use App\Models\Cashier;
use App\Events\SetterRedisEvent;


class CreateJWTDomains
{
     /**
     * Create a new token.
     * 
     * @param  \App\Models\Cashier   $user
     * @return string
     */
    public function __invoke(Cashier $user, Int $timeNext)
    {  
        
        $payload = [
            'iss' => "ironcore-jwt", // Issuer of the token
            'sub' => $user->cashier_id, // Subject of the token
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + ($timeNext * 60 * 60), // Expiration time second, example 24 * 60 * 60 = 86400 Secund
            'timeNext' => $timeNext
        ];


        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        $jwtToken = JWT::encode($payload, env('JWT_SECRET'));

        // Create token with cashier_id and tokenJWT
        $hashCheck = hash('sha256', $user->cashier_id.'-'.$jwtToken);

        $hashCheck = "JWT-$hashCheck";
        // check existe
        $token = ((bool) app('redis')->exists($hashCheck));
        if ($token) {
            app('redis')->del($hashCheck);
        } 
        Event(new SetterRedisEvent($hashCheck, $payload, $timeNext));
        
        return $jwtToken;
    }
}

