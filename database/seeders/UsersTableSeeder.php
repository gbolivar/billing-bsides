<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $options = [
            [
                'full_name' => 'Jose Antonio Blanco',
                'birthdate' => '1992-12-12',
                'sex' => 'MA',
                'phone' => '1127619977',
                'email' => 'jablanco@supermercado.com',
                'email_verified_at' => new \DateTime('now'),
                'slug'=> 'jose-antonio-blanco'
            ], 
            [
                'full_name' => 'Pedro Simón Pérez',
                'birthdate' => '1991-01-12',
                'sex' => 'MA',
                'phone' => '1128452968',
                'email' => 'psperez@supermercado.com',
                'email_verified_at' => new \DateTime('now'),
                'slug'=> 'pedro-simon-perez'
            ]
        ];
        foreach ($options as $key => $value) {
            $rows = [];
            foreach ($value as $item => $val) {
                $rows[$item] = $val;
            }
            
            $rowsTmp = $rows;
            // drop email_verified_at date change
            unset($rowsTmp['email_verified_at']);

            if (!(User::where($rowsTmp)->exists())) {
                User::create($rows);
            }
        }
    }
}

