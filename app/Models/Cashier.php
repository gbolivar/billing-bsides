<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



class Cashier extends Model
{
    protected $table = 'Cashiers';

    protected $fillable = [
        'subscription_id', 
    ];

}