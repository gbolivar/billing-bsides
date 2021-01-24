<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



class Customers extends Model
{
    protected $table = 'Customers';

    protected $fillable = [
        'subscription_id', 
    ];

}