<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Role::where('name', 'Super Admin')->first()) {
            Role::create([
                'name' => 'Super Admin'
            ]);
        }

        if (!Role::where('name', 'Admin')->first()) {
            $admin = Role::create([
                'name' => 'Admin'
            ]);

            $admin->givePermissionTo([
                //funções
                'list roles',
                'create role',
                'edit role',
                'destroy role',
                //permissões
                'list permissions',
                'update permission',
                //usuários
                'list users',
                'create user',
                'show user',
                'edit user',
                'destroy user',
                //clientes
                'list customers',
                'create customer',
                'show customer',
                'edit customer',
                'destroy customer',
                //níveis para clientes
                'list levels',
                'create level',
                'show level',
                'edit level',
                'destroy level',
                //endereços dos clientes
                'list addresses',
                'create address',
                'show address',
                'edit address',
                'destroy address',
                //gráficos
                'list dashboards',
                //unidades
                'list headquarters',
                'create headquarter',
                'show headquarter',
                'edit headquarter',
                'destroy headquarter',
                //categorias
                'list categories',
                'create category',
                'show category',
                'edit category',
                'destroy category',
                //montadoras
                'list automakers',
                'create automaker',
                'show automaker',
                'edit automaker',
                'destroy automaker',
                //marcas
                'list brands',
                'create brand',
                'show brand',
                'edit brand',
                'destroy brand',
                //fornecedores
                'list suppliers',
                'create supplier',
                'show supplier',
                'edit supplier',
                'destroy supplier',
                //produtos
                'list products',
                'create product',
                'show product',
                'edit product',
                'destroy product',
                //corridas
                'list races',
                'show race',
                'destroy race',
                //veículos
                'list vehicles',
                'create vehicle',
                'show vehicle',
                'edit vehicle',
                'destroy vehicle',
                //cotações
                'list budgets',
                'create budget',
                'show budget',
                'edit budget',
                'destroy budget',
                //etiquetagem
                'create labeling',
                //backups
                'list backups',
                'download backup',
                'destroy backup',
            ]);
        }

        if (!Role::where('name', 'Cliente')->first()) {
            $client = Role::create([
                'name' => 'Cliente'
            ]);
            $client->givePermissionTo([
                //carrinho
                'list cart',
                'store cart',
                'add cart',
                'remove cart',
                'destroy cart',
            ]);
        }

        if (!Role::where('name', 'Vendedor(a)')->first()) {
            $seller = Role::create([
                'name' => 'Vendedor(a)'
            ]);

            $seller->givePermissionTo([
                //categorias
                'list categories',
                'create category',
                'show category',
                'edit category',
                'destroy category',
                //montadoras
                'list automakers',
                'create automaker',
                'show automaker',
                'edit automaker',
                'destroy automaker',
                //marcas
                'list brands',
                'create brand',
                'show brand',
                'edit brand',
                'destroy brand',
                //fornecedores
                'list suppliers',
                'create supplier',
                'show supplier',
                'edit supplier',
                'destroy supplier',
                //produtos
                'list products',
                'create product',
                'show product',
                'edit product',
                'destroy product',
                //cotações
                'list budgets',
                'create budget',
                'show budget',
                'edit budget',
                'destroy budget',
                //clientes
                'list customers',
                'create customer',
                'show customer',
                'edit customer',
                'destroy customer',
                //endereços dos clientes
                'list addresses',
                'create address',
                'show address',
                'edit address',
                'destroy address',
            ]);
        }

        if (!Role::where('name', 'Almoxarife')->first()) {
            $storekeeper = Role::create([
                'name' => 'Almoxarife'
            ]);

            $storekeeper->givePermissionTo([
                //categorias
                'list categories',
                'create category',
                'show category',
                'edit category',
                'destroy category',
                //montadoras
                'list automakers',
                'create automaker',
                'show automaker',
                'edit automaker',
                'destroy automaker',
                //marcas
                'list brands',
                'create brand',
                'show brand',
                'edit brand',
                'destroy brand',
                //fornecedores
                'list suppliers',
                'create supplier',
                'show supplier',
                'edit supplier',
                'destroy supplier',
                //produtos
                'list products',
                'create product',
                'show product',
                'edit product',
                'destroy product',
                //etiquetagem
                'create labeling'
            ]);
        }

        if (!Role::where('name', 'Contabilista')->first()) {
            $accountant = Role::create([
                'name' => 'Contabilista'
            ]);

            $accountant->givePermissionTo([
                'list dashboards'
            ]);
        }

        if (!Role::where('name', 'Motorista/Piloto')->first()) {
            $driver = Role::create([
                'name' => 'Motorista/Piloto'
            ]);

            $driver->givePermissionTo([
                //corridas
                'list races',
                'begin race',
                'show race'
            ]);
        }
    }
}
