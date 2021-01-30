<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\Driver\Exception\ConnectionTimeoutException;

class AppLoggerIntercep extends Eloquent
{

    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'apps-logger-intercep';
    protected $fillable = ["tdx", "validate", "type", "typeDescription", "date"];

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
            AppLoggerIntercep::create($dataValue);
            return true;
        } catch (\Exception $e) {
            \Log::error(__METHOD__ . ' - AppLoggerIntercep creation failed', ['exception' => $e->getMessage()]);
            return false;
        }
    }

}
