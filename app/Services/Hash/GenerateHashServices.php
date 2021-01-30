<?php

namespace App\Services\Hash;

class GenerateHashServices
{

    public function __invoke()
    {
        $end = rand(0, 9);
        $token = str_replace('.', '', \microtime(true)) . "{$end}";
        return $token;
    }
}
