<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutomakerRequest;
use App\Models\Automaker;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutomakerController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list automakers', ['only' => ['index']]);
        $this->middleware('permission:create automaker', ['only' => ['create']]);
        $this->middleware('permission:show automaker', ['only' => ['show']]);
        $this->middleware('permission:edit automaker', ['only' => ['edit']]);
        $this->middleware('permission:destroy automaker', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $automakers = Automaker::get();
        return view('admin.automakers.index', compact('automakers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.automakers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutomakerRequest $request)
    {
        $request->validated();
        DB::beginTransaction();

        try {
            Automaker::create($request->all());
            DB::commit();
            return redirect()->route('automakers.index')->with('success', 'Montadora criada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao criar uma montadora: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar montadora. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $automaker = Automaker::findOrFail($id);
        $productsRelated = Product::where('automaker_id', $id)->count();
        return view('admin.automakers.show', compact('automaker', 'productsRelated'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $automaker = Automaker::findOrFail($id);
        return view('admin.automakers.edit', compact('automaker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutomakerRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $automaker = Automaker::findOrFail($id);
            $automaker->update($request->validated());
            DB::commit();
            return redirect()->route('automakers.index')->with('success', 'Montadora editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao editar uma montadora: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar montadora. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $automaker = Automaker::findOrFail($id);
            $automaker->delete();
            DB::commit();
            return redirect()->route('automakers.index')->with('success', 'Montadora apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar uma montadora: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar montadora. Contate o suporte para saber mais sobre.');
        }
    }
}
