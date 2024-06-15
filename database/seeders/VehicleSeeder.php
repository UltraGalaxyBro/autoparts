<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Vehicle::where('license_plate', 'PRB1I73')->first()) {
            Vehicle::create([
                'type' => 'CARRO',
                'name' => 'Saveiro, cor prata',
                'license_plate' => 'PRB1I73'
            ]);
        }

        if (!Vehicle::where('license_plate', 'PUP2D95')->first()) {
            Vehicle::create([
                'type' => 'MOTO',
                'name' => 'CG-150 Titanium, cor preto/vinho',
                'license_plate' => 'PUP2D95'
            ]);
        }
    }
}
