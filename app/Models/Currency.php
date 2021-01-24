<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use MongoDB\Driver\Exception\ConnectionTimeoutException;

class Currency extends Eloquent
{

    public $timestamps = false;
    protected $connection = 'mongodb';
    protected $collection = 'currency';
    protected $fillable = ["date", "base", "currency", "rate"];

    protected $hidden = [
        "_id"
    ];

}
