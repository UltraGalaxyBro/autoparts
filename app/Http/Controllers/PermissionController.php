<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list permissions', ['only' => ['index']]);
        $this->middleware('permission:update permission', ['only' => ['update']]);
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name == 'Super Admin') {
            Log::warning('Tentativa de acessar as permissões de função "Super Admin".', ['action_user_id' => Auth::id()]);
            return redirect()->route('roles.index')->with('error', 'As permissões de "Super Admin" não podem ser acessadas ou alteradas.');
        }
        $rolePermissions = DB::table('role_has_permissions')->where('role_id', $id)->pluck('permission_id')->all();
        $permissions = Permission::get();
        Log::info('Listando todas as permissões de uma função.', ['role_id' => $id, 'action_user_id' => Auth::id()]);

        return view('admin.permissions.index', compact('role', 'rolePermissions', 'permissions'));
    }

    public function update(Request $request, string $id)
    {
        //VERIFICANDO SE A PERMISSÃO EXISTE
        $permission = Permission::findOrFail($id);
        if (!$permission) {
            return redirect()->route('permissions.index', ['role_id' => $request->role_id])->with('error', 'Permissão não encontrada!');
        }

        //VERIFICANDO SE ESTA PERMISSÃO JÁ ESTÁ ASSOCIADA A FUNÇÃO EM QUESTÃO
        $role = Role::findOrFail($request->role_id);
        if ($role->permissions->contains($permission)) {
            //removendo a permissão desta função
            $role->revokePermissionTo($permission);
            Log::info('Permissão bloqueada!', ['action_user_id' => Auth::id(), 'role' => $role, 'permission' => $permission]);
            return redirect()->route('permissions.index', ['role_id' => $request->role_id])->with('success', 'Permissão bloqueada com sucesso!');
        } else {
            //adicionando a permissão para esta função
            $role->givePermissionTo($permission);
            Log::info('Permissão autorizada!', ['action_user_id' => Auth::id(), 'role' => $role, 'permission' => $permission]);
            return redirect()->route('permissions.index', ['role_id' => $request->role_id])->with('success', 'Permissão autorizada com sucesso!');
        }
    }
}
