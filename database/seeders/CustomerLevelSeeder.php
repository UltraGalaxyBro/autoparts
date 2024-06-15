<?php

namespace Database\Seeders;

use App\Models\CustomerLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!CustomerLevel::where('name', 'Nível D')->first()) {
            CustomerLevel::create([
                'name' => 'Nível D',
                'discount' => '0.00',
                'description' => 'Neste nível já é possível acessar a nossa plataforma para enviar cotações aos nossos vendedores. Continue comprando para acessar níveis melhores de cliente e possuir descontos exclusivos em futuras compras.'
            ]);
        }
    }
}
