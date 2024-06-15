<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //ADICIONADO A COLUNA TÍTULO PARA CRIAR MAIS FAMILIARIDADE COM O USUÁRIO
            //funções
            ['title' => 'Listar funções', 'name' => 'list roles'],
            ['title' => 'Criar função', 'name' => 'create role'],
            ['title' => 'Editar função', 'name' => 'edit role'],
            ['title' => 'Apagar função', 'name' => 'destroy role'],
            //permissões
            ['title' => 'Listar permissões', 'name' => 'list permissions'],
            ['title' => 'Atualizar permissão', 'name' => 'update permission'],
            //usuários
            ['title' => 'Listar usuários', 'name' => 'list users'],
            ['title' => 'Criar usuário', 'name' => 'create user'],
            ['title' => 'Mostrar usuário', 'name' => 'show user'],
            ['title' => 'Editar usuário', 'name' => 'edit user'],
            ['title' => 'Apagar usuário', 'name' => 'destroy user'],
            //clientes
            ['title' => 'Listar clientes', 'name' => 'list customers'],
            ['title' => 'Criar cliente', 'name' => 'create customer'],
            ['title' => 'Mostrar cliente', 'name' => 'show customer'],
            ['title' => 'Editar cliente', 'name' => 'edit customer'],
            ['title' => 'Apagar cliente', 'name' => 'destroy customer'],
            //níveis de clientes
            ['title' => 'Listar níveis dos clientes', 'name' => 'list levels'],
            ['title' => 'Criar nível dos clientes', 'name' => 'create level'],
            ['title' => 'Mostrar nível dos clientes', 'name' => 'show level'],
            ['title' => 'Editar nível dos clientes', 'name' => 'edit level'],
            ['title' => 'Apagar nível dos clientes', 'name' => 'destroy level'],
            //endereços de clientes
            ['title' => 'Listar endereços dos clientes', 'name' => 'list addresses'],
            ['title' => 'Criar endereço do cliente', 'name' => 'create address'],
            ['title' => 'Mostrar endereço do cliente', 'name' => 'show address'],
            ['title' => 'Editar endereço do cliente', 'name' => 'edit address'],
            ['title' => 'Apagar endereço do cliente', 'name' => 'destroy address'],
            //gráficos
            ['title' => 'Visualizar gráficos', 'name' => 'list dashboards'],
            //cotações
            ['title' => 'Visualizar cotações', 'name' => 'list budgets'],
            ['title' => 'Criar cotação', 'name' => 'create budget'],
            ['title' => 'Mostrar cotação', 'name' => 'show budget'],
            ['title' => 'Editar cotação', 'name' => 'edit budget'],
            ['title' => 'Apagar cotação', 'name' => 'destroy budget'],
            //unidades
            ['title' => 'Listar unidades', 'name' => 'list headquarters'],
            ['title' => 'Criar unidade', 'name' => 'create headquarter'],
            ['title' => 'Mostrar unidade', 'name' => 'show headquarter'],
            ['title' => 'Editar unidade', 'name' => 'edit headquarter'],
            ['title' => 'Apagar unidade', 'name' => 'destroy headquarter'],
            //categorias
            ['title' => 'Listar categorias', 'name' => 'list categories'],
            ['title' => 'Criar categoria', 'name' => 'create category'],
            ['title' => 'Mostrar categoria', 'name' => 'show category'],
            ['title' => 'Editar categoria', 'name' => 'edit category'],
            ['title' => 'Apagar categoria', 'name' => 'destroy category'],
            //montadoras
            ['title' => 'Listar montadoras', 'name' => 'list automakers'],
            ['title' => 'Criar montadora', 'name' => 'create automaker'],
            ['title' => 'Mostrar montadora', 'name' => 'show automaker'],
            ['title' => 'Editar montadora', 'name' => 'edit automaker'],
            ['title' => 'Apagar montadora', 'name' => 'destroy automaker'],
            //marcas
            ['title' => 'Listar marcas', 'name' => 'list brands'],
            ['title' => 'Criar marca', 'name' => 'create brand'],
            ['title' => 'Mostrar marca', 'name' => 'show brand'],
            ['title' => 'Editar marca', 'name' => 'edit brand'],
            ['title' => 'Apagar marca', 'name' => 'destroy brand'],
            //fornecedores
            ['title' => 'Listar fornecedores', 'name' => 'list suppliers'],
            ['title' => 'Criar fornecedor', 'name' => 'create supplier'],
            ['title' => 'Mostrar fornecedor', 'name' => 'show supplier'],
            ['title' => 'Editar fornecedor', 'name' => 'edit supplier'],
            ['title' => 'Apagar fornecedor', 'name' => 'destroy supplier'],
            //produtos
            ['title' => 'Listar produtos', 'name' => 'list products'],
            ['title' => 'Criar produto', 'name' => 'create product'],
            ['title' => 'Mostrar produto', 'name' => 'show product'],
            ['title' => 'Editar produto', 'name' => 'edit product'],
            ['title' => 'Apagar produto', 'name' => 'destroy product'],
            //etiquetagem
            ['title' => 'Gerar etiquetas', 'name' => 'create labeling'],
            //corridas
            ['title' => 'Listar corridas', 'name' => 'list races'],
            ['title' => 'Começar corrida', 'name' => 'begin race'],
            ['title' => 'Mostrar corrida', 'name' => 'show race'],
            ['title' => 'Apagar corrida', 'name' => 'destroy race'],
            //veículos
            ['title' => 'Listar veículos', 'name' => 'list vehicles'],
            ['title' => 'Criar veículo', 'name' => 'create vehicle'],
            ['title' => 'Mostrar veículo', 'name' => 'show vehicle'],
            ['title' => 'Editar veículo', 'name' => 'edit vehicle'],
            ['title' => 'Apagar veículo', 'name' => 'destroy vehicle'],
            //carrinho
            ['title' => 'Listar carrinho', 'name' => 'list cart'],
            ['title' => 'Armazenar produto ao carrinho', 'name' => 'store cart'],
            ['title' => 'Aumentar quantidade do produto no carrinho', 'name' => 'add cart'],
            ['title' => 'Diminuir quantidade do produto no carrinho', 'name' => 'remove cart'],
            ['title' => 'Deletar produto do carrinho', 'name' => 'destroy cart'],
            //backups
            ['title' => 'Listar backups armazenados', 'name' => 'list backups'],
            ['title' => 'Realizar download do backup', 'name' => 'download backup'],
            ['title' => 'Apagar backup', 'name' => 'destroy backup'],
        ];

        foreach ($permissions as $permission) {
            $existigPermission = Permission::where('name', $permission)->first();
            if (!$existigPermission) {
                Permission::create([
                    'title' => $permission['title'],
                    'name' => $permission['name'],
                    'guard_name' => 'web'
                ]);
            }
        }
    }
}
