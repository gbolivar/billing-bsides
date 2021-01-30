<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class InvoiceDetail extends Model
{
    protected $table = 'invoices_details';

    protected $fillable = [
        'subscription_id', 
    ];

}