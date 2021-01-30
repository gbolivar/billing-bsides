<?php

namespace App\Services\Hash;
use App\Services\Hash\GenerateHashServices;

class GenerateTdxIdServices
{

    private static $instances = [];

    public static function getInstance(): GenerateTdxIdServices
    {
        $cls = static::class;
        if (!isset(static::$instances[$cls])) {
            static::$instances[$cls] = new static;
        }

        return static::$instances[$cls];
    }

    /**
     * Generate x-transaction-id
     * @return Date $date UTC
     */
    public function main()
    {  
        return strtoupper('core-'.hash('sha256',((new GenerateHashServices())())));
    }
}
