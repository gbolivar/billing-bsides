<?php

namespace App\Events;

class SetterRedisEvent extends Event
{
    /**
     * Create a new event instance.
     * @param String $token
     * @param Json $dataJson
     * @param Boolean $expire
     * @return void
     */
    public function __construct($token, $dataJson, $expire = null)
    {
        $timExpire = (int) (($expire??env('REDIS_ITEM_EXPIRATION')) * (60 * 60));
        try {
            $this->processRedis($token, $dataJson, $timExpire);
        } catch (\Throwable $th) {
            $this->processRedis($token, $dataJson, $timExpire);
        }
    }


    /**
     * Process Redis.
     * @param String $token
     * @param Json $dataJson
     * @param Boolean $expire
     * @return void
     */
    private function processRedis($token, $dataJson, $timExpire)
    {
        app('redis')->set($token, json_encode($dataJson));
        app('redis')->expire($token, $timExpire);
    }
}