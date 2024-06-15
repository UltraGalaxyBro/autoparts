<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthCreateRequest;
use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRecoveryRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Spatie\Permission\Models\Permission;

class AuthController extends Controller
{

    //LOGIN
    public function index()
    {
        return view('auth.login');
    }

    public function process(AuthLoginRequest $request)
    {
        $request->validated();
        $autenticated = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if (!$autenticated) {
            return back()->withInput()->with('error', 'E-mail ou senha inválido.');
        }

        //RECUPERANDO O ID APÓS A AUTENTICAÇÃO
        $user = Auth::user();
        $user = User::find($user->id);

        if ($user->hasRole('Super Admin')) {
            //CONCEDENDO ACESSO POR TODO O SISTEMA
            $permissions = Permission::pluck('name')->toArray();
        } else {
            $permissions = $user->getPermissionsViaRoles()->pluck('name')->toArray();
        }

        $user->syncPermissions($permissions);
        if($user->hasRole('Cliente')){
            return redirect()->route('welcome');
        } else {
            return redirect()->route('admin.home');
        }
    }

    //RECUPERAR ACESSO
    public function recovery()
    {
        return view('auth.recovery');
    }

    public function recovering(AuthRecoveryRequest $request)
    {
        $request->validated();
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withInput()->with('error', 'E-mail não cadastrado.');
        }

        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );

            return redirect()->route('auth.login')->with('success', 'Enviado um e-mail com instruções para a recuperação. Acesse o e-mail informado para visualizar.');
        } catch (Exception $e) {
            Log::error('Tentativa de recuperar a senha tendo as instruções enviadas ao e-mail informado pelo usuário. Segue o erro: ' . $e);
            return redirect()->route('auth.login')->with('error', 'Erro no processo. Contate o suporte para mais detalhes.');
        }
    }

    public function reset(Request $request)
    {
        return view('auth.reset', ['token' => $request->token]);
    }

    public function resetting(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) {
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ]);

                    $user->save();
                }
            );

            return $status === Password::PASSWORD_RESET ? redirect()->route('auth.login')->with('success', 'Senha redefinida com sucesso!')  : back()->withInput()->with('error', __($status));
        } catch (Exception $e) {
            Log::error('Tentativa de redefinir a senha do usuário. Segue o erro: ' . $e);
            return back()->withInput()->with('error', 'Não foi possível redefinir a senha. Contate o suporte para mais detalhes.');
        }
    }

    //CRIAR CONTA
    public function create()
    {
        return view('auth.create');
    }

    public function store(AuthCreateRequest $request)
    {
        $request->validated();
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            $user->assignRole('Cliente');

            DB::commit();
            return redirect()->route('auth.login')->with('success', 'Usuário cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa de criar o usuário. Segue o erro: ' . $e);
            return back()->withInput()->with('error', 'Não foi possível criar a conta. Contate o suporte para mais detalhes.');
        }
    }

    //FAZER LOGOUT
    public function destroy()
    {
        Auth::logout();
        return redirect()->route('auth.login')->with('success', 'Deslogado com sucesso!');
    }
}
