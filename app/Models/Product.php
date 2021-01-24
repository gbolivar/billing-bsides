<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'subscription_id', 
    ];

}