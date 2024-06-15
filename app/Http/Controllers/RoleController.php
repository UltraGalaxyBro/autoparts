<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list roles', ['only' => ['index']]);
        $this->middleware('permission:create role', ['only' => ['create']]);
        $this->middleware('permission:edit role', ['only' => ['edit']]);
        $this->middleware('permission:destroy role', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => ['required', 'unique:roles,name']
            ],
            [
                'name.required' => 'O campo para o nome da função é obrigatório ser preenchido.',
                'name.unique' => 'Já existe uma função cadastrada com este nome.'
            ]
        );

        DB::beginTransaction();

        try {
            Role::create([
                'name' => $request->name
            ]);
            DB::commit();
            Log::info('Função cadastrada!', ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('success', 'Função cadastrada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro não esperado ao cadastrar uma função. Erro: ' . $e, ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('error', 'Algo deu errado ao cadastrar uma função. Contate o suporte!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => ['required', Rule::unique('roles')->ignore($id)]
            ],
            [
                'name.required' => 'O campo para o nome da função é obrigatório ser preenchido.',
                'name.unique' => 'Já existe uma função cadastrada com este nome.'
            ]
        );

        DB::beginTransaction();

        try {
            $role = Role::findOrFail($id);

            $role->update([
                'name' => $request->name
            ]);
            DB::commit();
            Log::info('Função editada!', ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('success', 'Função editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro não esperado ao editar uma função. Erro: ' . $e, ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('error', 'Algo deu errado ao cadastrar uma função. Contate o suporte!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        //Não deixando excluir funções mega importantes
        if ($role->name == 'Super Admin' || $role->name == 'Admin') {
            Log::warning('Tentativa em apagar a função "Super Admin" ou "Admin".', ['role' => $role, 'action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('error', 'Não é possível excluir funções essenciais ao sistema.');
        }
        //Não deixando ser excluída alguma função que detenha algum usuário
        if ($role->users->isNotEmpty()) {
            Log::warning('Tentativa em excluir uma função que já está atribuída para ao menos um usuário.', ['role' => $role, 'action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('error', 'Não é possível excluir uma função que já esteja vinculada a algum usuário.');
        }

        DB::beginTransaction();

        try {
            $role->delete();
            DB::commit();
            Log::info('Função apagada!', ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('success', 'Função apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro acusado ao tentar apagar uma função: ' . $e, ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('error', 'Erro ao tentar apagar a função. Contate o suporte!');
        }
    }
}
