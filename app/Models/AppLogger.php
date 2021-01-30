<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\Driver\Exception\ConnectionTimeoutException;

class AppLogger extends Eloquent
{

    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'apps-logger-data';
    protected $fillable = ["tdx", "validate", "type", "typeDescription", 'events', "date"];

    protected $hidden = [
        "_id"
    ];

    /**
     * Register data
     * @param Array $dataValue
     */
    public static function toRegister($dataValue)
    {
        try {
            AppLogger::create($dataValue);
            return true;
        } catch (\Exception $e) {
            \Log::error(__METHOD__ . ' - AppLogger creation failed', ['exception' => $e->getMessage()]);
            return false;
        }
    }

}
