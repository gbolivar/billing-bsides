<?php

namespace App\Services\Logger;

use App\Models\AppLogger;
use \MongoDB\BSON\UTCDateTime as UTCMongo;


class LoggerEventsServices
{
    public function __invoke(String $logger = 'info', String $inpact, Array $request): void
    {
        $tdx = \Cache::get('TDX');
        \Log::$logger("TDX [ {$tdx} ] -- {$inpact}", [$request]);

    }
}

