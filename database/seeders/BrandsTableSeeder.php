<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
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
                'label' => 'Logitch',
            ],
            [
                'label' => 'Samsung',
            ],
            [
                'label' => 'LG',
            ],
            [
                'label' => 'Alfa',
            ],
            [
                'label' => 'Dell',
            ],
            [
                'label' => 'Xiaomi',
            ],

        ];
        foreach ($options as $key => $value) {
            $rows = [];
            foreach ($value as $item => $val) {
                $rows[$item] = $val;
            }
            
            $rowsTmp = $rows;
            if (!(Brand::where($rowsTmp)->exists())) {
                Brand::create($rows);
            }
        }
    }
}

