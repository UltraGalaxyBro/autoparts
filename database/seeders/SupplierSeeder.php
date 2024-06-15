<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Supplier::where('name', 'NULO')->first()) {
            Supplier::create([
                'name' => '*NULO*'
            ]);
        }
    }
}
