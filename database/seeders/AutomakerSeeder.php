<?php

namespace Database\Seeders;

use App\Models\Automaker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AutomakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        if (!Automaker::where('name', 'Mercedes-Benz')->first()) {
            Automaker::create([
                'name' => 'Mercedes-Benz',
                'shard_code' => '01'
            ]);
        }

        if (!Automaker::where('name', 'Volvo')->first()) {
            Automaker::create([
                'name' => 'Volvo',
                'shard_code' => '02'
            ]);
        }

        if (!Automaker::where('name', 'Volkswagen')->first()) {
            Automaker::create([
                'name' => 'Volkswagen',
                'shard_code' => '03'
            ]);
        }

        if (!Automaker::where('name', 'Ford')->first()) {
            Automaker::create([
                'name' => 'Ford',
                'shard_code' => '04'
            ]);
        }

        if (!Automaker::where('name', 'Scania')->first()) {
            Automaker::create([
                'name' => 'Scania',
                'shard_code' => '05'
            ]);
        }

        if (!Automaker::where('name', 'Iveco')->first()) {
            Automaker::create([
                'name' => 'Iveco',
                'shard_code' => '06'
            ]);
        }

        if (!Automaker::where('name', 'DAF')->first()) {
            Automaker::create([
                'name' => 'DAF',
                'shard_code' => '07'
            ]);
        }

        if (!Automaker::where('name', 'OUTRAS')->first()) {
            Automaker::create([
                'name' => 'OUTRAS',
                'shard_code' => '08'
            ]);
        }

        if (!Automaker::where('name', 'GERAL')->first()) {
            Automaker::create([
                'name' => 'GERAL',
                'shard_code' => '09'
            ]);
        }
    }
}
