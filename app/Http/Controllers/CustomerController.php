<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use App\Models\CustomerLevel;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list customers', ['only' => ['index']]);
        $this->middleware('permission:create customer', ['only' => ['create']]);
        $this->middleware('permission:show customer', ['only' => ['show']]);
        $this->middleware('permission:edit customer', ['only' => ['edit']]);
        $this->middleware('permission:destroy customer', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //BUSCANDO OS USUÁRIOS QUE POSSUEM A FUNÇÃO DE CLIENTE E QUE NÃO ESTÃO CRIADOS NA TABELA CUSTOMERS AINDA
        $users = User::role('Cliente')
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')
                    ->from('customers');
            })
            ->get();
        $levels = CustomerLevel::get();
        return view('admin.customers.create', compact('users', 'levels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $request->validated();

        if ($request->whatsappSign == 'on') {
            $request->merge(['whatsapp' => 'Sim']);
        } else {
            $request->merge(['whatsapp' => 'Não']);
        }

        DB::beginTransaction();

        try {

            if (!is_numeric($request->user_id)) {
                if (!User::where('name', $request->user_id)->first()) {
                    $tempEmail = uniqid() . '@cliente.com';
                    $user = User::create([
                        'name' => $request->user_id,
                        'email' => $tempEmail,
                        'password' => Hash::make('0123456789')
                    ]);
                    $user->assignRole('Cliente');
                    $request->merge([
                        'user_id' => $user->id
                    ]);
                } else {
                    return redirect()->back()->with('warning', 'Já existe este usuário como cliente. Selecione a opção existente deste cliente.');
                }
            }

            Customer::create($request->all());
            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Cliente com dados essenciais cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Aconteceu um erro ao criar um cliente. Erro apresentado: ' . $e);
            return redirect()->back()->with('error', 'Algo estranho ocorreu e não foi possível executar esta ação. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        $users = User::role('Cliente')
            ->whereNotIn('id', function ($query) {
                $query->select('user_id')
                    ->from('customers');
            })
            ->get();
        $levels = CustomerLevel::get();
        return view('admin.customers.edit', compact('customer', 'users', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $id)
    {
        $request->validated();
        if ($request->whatsappSign == 'on') {
            $request->merge(['whatsapp' => 'Sim']);
        } else {
            $request->merge(['whatsapp' => 'Não']);
        }

        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id);
            $customer->update($request->all());
            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Cliente com dados essenciais editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Aconteceu um erro ao editar um cliente. Erro apresentado: ' . $e);
            return redirect()->back()->with('error', 'Algo estranho ocorreu e não foi possível executar esta ação. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        DB::beginTransaction();

        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();
            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Registro de cliente apagado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar um cliente: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar registro de cliente. Contate o suporte para saber mais sobre.');
        }
    }
}
