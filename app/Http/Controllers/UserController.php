<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Headquarter;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list users', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create']]);
        $this->middleware('permission:show user', ['only' => ['show']]);
        $this->middleware('permission:edit user', ['only' => ['edit']]);
        $this->middleware('permission:destroy user', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name')->all();
        $headquarters = Headquarter::get();
        return view('admin.users.create', compact('roles', 'headquarters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $request->validated();
        DB::beginTransaction();

        //dd($request);

        try {
            if ($request->roles === 'Cliente') {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'headquarter_id' => $request->headquarter_id,
                ]);
            }

            $user->markEmailAsVerified();
            $user->assignRole($request->roles);
            DB::commit();
            Log::info('Usuário cadastrado de dentro do sistema', ['id' => $user->id, $user, 'action_user_id' => Auth::id()]);
            return redirect()->route('users.index')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Em tentativa de criar um usuário por dentro do sistema da CO2 Peças: ' . $e);
            return redirect()->back()->with('Erro ao tentar criar usuário. Contate o suporte para mais detalhes.');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name')->all();
        $headquarters = Headquarter::get();
        $userRole = $user->roles->pluck('name')->first();
        return view('admin.users.edit', compact('user', 'roles', 'userRole', 'headquarters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $request->validated();
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->updatePassword == 'Sim') {
                $updateData['password'] = Hash::make($request->password);
            }

            if ($request->roles !== 'Cliente') {
                $updateData['headquarter_id'] = $request->headquarter_id;
            }

            $user->update($updateData);

            $user->syncRoles($request->roles);
            DB::commit();
            Log::info('Usuário editado de dentro do sistema', ['id' => $user->id, $user, 'action_user_id' => Auth::id()]);
            return redirect()->route('users.index')->with('success', 'Usuário editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Em tentativa de editar um usuário por dentro do sistema da CO2 Peças: ' . $e);
            return redirect()->back()->with('Erro ao tentar editar usuário. Contate o suporte para mais detalhes.');
        }
    }

    public function selfShow(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.selfShow', compact('user'));
    }

    public function selfEdit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.selfEdit', compact('user'));
    }

    public function selfUpdate(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($id)],
            'password' => ['required_if:updatePassword,Sim', 'confirmed'],
            'password_confirmation' => ['required_if:updatePassword,Sim'],

        ], [
            'name.required' => 'Campo para nome completo é obrigatório.',
            'email.required' => 'Campo para e-mail é obrigatório.',
            'email.email' => 'Necessário que seja em formato de e-mail.',
            'email.unique' => 'Conta com este e-mail já cadastrada.',
            'password.required' => 'Campo para senha é obrigatório.',
            'password.required_if' => 'O campo de senha é necessário caso esteja marcado que irá alterar as senhas nesta edição.',
            'password.min' => 'Campo para senha deve conter ao menos 8 caracteres.',
            'password_confirmation.required' => 'Campo para confirmar senha é obrigatório.',
            'password_confirmation.required_if' => 'O campo de confirmar senha é necessário caso esteja marcado que irá alterar as senhas nesta edição.',
            'password.confirmed' => 'As senhas não conferem.',
        ]);

        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            if ($request->updatePassword == 'Sim') {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            } else {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }
            DB::commit();
            return redirect()->route('users.self-show', ['id' => $id])->with('success', 'Você editou com sucesso sua conta!');
        } catch (Exception $e) {
            Log::error('Ocorrido quando o usuário por si só procurou alterar seus dados: ' . $e);
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $user->syncRoles([]);
            Log::info('Usuário apagado de dentro do sistema', ['id' => $user->id, $user, 'action_user_id' => Auth::id()]);
            DB::commit();
            return redirect()->route('users.index')->with('success', 'Usuário apagado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Em tentativa de apagar um usuário por dentro do sistema da CO2 Peças: ' . $e);
            return redirect()->back()->with('Erro ao tentar apagar usuário. Contate o suporte para mais detalhes.');
        }
    }
}
