<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cashier;
use Illuminate\Database\Seeder;


class CashiersTableSeeder extends Seeder
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
                'user_id' => User::where('slug', 'jose-antonio-blanco')->first()->id,
                'login' => 'joseblanco',
                'passwd' => hash('sha512', 'J0s3bl4nc0..*'),
            ],
            [
                'user_id' => User::where('slug', 'pedro-simon-perez')->first()->id,
                'login' => 'pedroperez',
                'passwd' => hash('sha512', 'P3dr0p3r4z..*')
            ]
        ];
        foreach ($options as $key => $value) {
            $rows = [];
            foreach ($value as $item => $val) {
                $rows[$item] = $val;
            }
            
            $rowsTmp = $rows;
            if (!(Cashier::where($rowsTmp)->exists())) {
                Cashier::create($rows);
            }
        }
    }
}

