<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



class InvoiceDetail extends Model
{
    protected $table = 'InvoicesDetails';

    protected $fillable = [
        'subscription_id', 
    ];

}