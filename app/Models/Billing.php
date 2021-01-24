<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



class Billing extends Model
{
    protected $table = 'billing';

    protected $fillable = [
        'subscription_id', 
    ];

}