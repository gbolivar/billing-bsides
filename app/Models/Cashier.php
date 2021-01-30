<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Cashier extends Model
{
    protected $table = 'cashiers';

    protected $fillable = [
        'user_id', 'login', 'passwd', 
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * Search cashier
     * @param Array $data
     * @return Cashier $value 
     */
    public static function findOneLogin($data)
    {
        try {
            // Get data users and join users
            $pass = hash('sha512', $data['password']);
            return Cashier::select(['*', 'cashiers.id as cashier_id'])
                            ->join('users', 'users.id','=','cashiers.user_id')
                            ->where('login', $data['login'])
                            ->where('passwd', $pass)
                            ->where('users.status', true)
                            ->first();
        } catch (\Exception $e) { 
            dd($e->getMessage());
            \Log::error(__METHOD__ . ' - currency search failed', ['exception' => $e->getMessage()]);
            return false;
        }
    }


    /**
     * Search currency between data
     * @param Integer $id
     * @return Cashier $value 
     */
    public static function findOneId(Int $id)
    {
        try {
            return Cashier::select(['*', 'cashiers.id as cashier_id'])
                            ->join('users', 'users.id','=','cashiers.user_id')
                            ->where('cashiers.id', $id)
                            ->where('users.status', true)
                            ->first();
        } catch (\Exception $e) {
            dd($e->getMessage());
            \Log::error(__METHOD__ . ' - currency search failed', ['exception' => $e->getMessage()]);
            return false;
        }
    }



}