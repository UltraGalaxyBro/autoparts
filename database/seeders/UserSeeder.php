<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!User::where('email', 'pablonogueira1996@gmail.com')->first()) {
            $superAdmin = User::create([
                'name' => 'Pablo Nogueira',
                'email' => 'pablonogueira1996@gmail.com',
                'password' => Hash::make('superadminuser')
            ]);

            $superAdmin->assignRole('Super Admin');
        }

        if (!User::where('email', 'testtest@gmail.com')->first()) {
            $admin = User::create([
                'name' => 'Imaginário Imaginado',
                'email' => 'testtest@outlook.com',
                'password' => Hash::make('adminuser')
            ]);

            $admin->assignRole('Admin');
        }

    }
}
