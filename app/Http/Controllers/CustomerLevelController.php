<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerLevelRequest;
use App\Models\Customer;
use App\Models\CustomerLevel;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerLevelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list levels', ['only' => ['index']]);
        $this->middleware('permission:create level', ['only' => ['create']]);
        $this->middleware('permission:show level', ['only' => ['show']]);
        $this->middleware('permission:edit level', ['only' => ['edit']]);
        $this->middleware('permission:destroy level', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $levels = CustomerLevel::get();
        return view('admin.levels.index', compact('levels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.levels.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerLevelRequest $request)
    {
        $request->validated();

        DB::beginTransaction();
        try {
            CustomerLevel::create($request->all());
            DB::commit();
            return redirect()->route('levels.index')->with('success', 'Nível para clientes criado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Não foi possível criar um novo nível para clientes. Segue erro: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar nível para clientes. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $level = CustomerLevel::findOrFail($id);
        $totalClients = Customer::where('customer_level_id', $id)->count();
        return view('admin.levels.show', compact('level', 'totalClients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $level = CustomerLevel::findOrFail($id);
        return view('admin.levels.edit', compact('level'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerLevelRequest $request, string $id)
    {
        $request->validated();
        $level = CustomerLevel::findOrFail($id);
        DB::beginTransaction();

        try {
            $level->update($request->all());
            DB::commit();
            return redirect()->route('levels.index')->with('success', 'Nível para clientes editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Não foi possível editar este nível para clientes. Segue o erro sobre o customer_level de id ' . $id . ': ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar nível para clientes. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $level = CustomerLevel::findOrFail($id);
        DB::beginTransaction();

        try {
            $level->delete();
            DB::commit();
            return redirect()->route('levels.index')->with('success', 'Nível para clientes apagado com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Não foi possível apagar o nível para clientes. Segue o erro: ' . $e);
            return redirect()->route('levels.index')->with('error', 'Erro ao apagar nível para clientes. Contate o suporte para saber mais sobre.');
        }
    }
}
