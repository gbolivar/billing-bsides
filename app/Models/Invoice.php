b   <?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;



class Invoices extends Model
{
    protected $table = 'Invoices';

    protected $fillable = [
        'subscription_id', 
    ];

}