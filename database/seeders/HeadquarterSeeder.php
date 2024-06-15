<?php

namespace Database\Seeders;

use App\Models\Headquarter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadquarterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Headquarter::where('name', 'Loja pioneira')->first()) {
            Headquarter::create([
                'visible' => 'Sim',
                'name' => 'Loja pioneira',
                'zip_code' => '74425086',
                'state' => 'GO',
                'city' => 'Goiânia',
                'neighborhood' => 'Vila Aurora Oeste',
                'street' => 'Av. Eng. Atílio Correia Lima, Qd. 105, Lt.11',
                'number' => '1820',
                'complement' => 'Em frente à saída do DETRAN',
                'telephone' => '(62) 3210-1546',
                'whatsapp' => '(62) 9 9807-6711',
                'map' => 'https://maps.app.goo.gl/BH9rAy3D1dGbJ21i7',
                'coordinates' => '-16.68103853746633, -49.307424871607616',
                'main_img' => 'loja_pioneira.jpg'
            ]);
        }
    }
}
