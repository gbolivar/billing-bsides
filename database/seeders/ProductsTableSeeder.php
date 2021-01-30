<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
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
                'brand_id' => 1,
                'label' => 'Teclado',
                'description' => 'Teclado en Español Ergonomico de 186 Teclas.',
                'code' => 'Mk320-0001',
                'price' => 50,
            ],
            [
                'brand_id' => 2,
                'label' => 'Monitor',
                'description' => 'Monitor Plano Gamer 75 Hz',
                'code' => 'SA254-0001',
                'price' => 101,
            ],
            [
                'brand_id' => 3,
                'label' => 'Camara Full HD',
                'description' => 'Web Cam profesional con Microfono',
                'code' => 'CMJ34-0012',
                'price' => 40,
            ],
            [
                'brand_id' => 4,
                'label' => 'Antena Wifi Alfa',
                'description' => 'Antena Alfa Wifi soporta Kali Linux',
                'code' => 'Al360-0012',
                'price' => 70,
            ]

        ];
        foreach ($options as $key => $value) {
            $rows = [];
            foreach ($value as $item => $val) {
                $rows[$item] = $val;
            }
            
            $rowsTmp = $rows;


            if (!(Product::where($rowsTmp)->exists())) {
                Product::create($rows);
            }
        }
    }
}




