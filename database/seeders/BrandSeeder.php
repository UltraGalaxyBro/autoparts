<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Brand::where('name', '*GENUINE PARTS (ORIGINAL)*')->first()) {
            Brand::create([
                'name' => '*GENUINE PARTS (ORIGINAL)*'
            ]);
        }

        if (!Brand::where('name', '*SOB CONSULTA*')->first()) {
            Brand::create([
                'name' => '*SOB CONSULTA*'
            ]);
        }
      
    }
}
