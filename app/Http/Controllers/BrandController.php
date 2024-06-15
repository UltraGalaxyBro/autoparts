<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list brands', ['only' => ['index']]);
        $this->middleware('permission:create brand', ['only' => ['create']]);
        $this->middleware('permission:show brand', ['only' => ['show']]);
        $this->middleware('permission:edit brand', ['only' => ['edit']]);
        $this->middleware('permission:destroy brand', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::orderByDesc('created_at')->get();
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $request->validated();
        DB::beginTransaction();

        try {
            Brand::create($request->all());
            DB::commit();
            return redirect()->route('brands.index')->with('success', 'Marca criada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao criar uma marca: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar marca. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $brand = Brand::findOrFail($id);
        $productsRelated = Product::where('brand_id', $id)->count();
        return view('admin.brands.show', compact('brand', 'productsRelated'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $brand = Brand::findOrFail($id);
            $brand->update($request->validated());
            DB::commit();
            return redirect()->route('brands.index')->with('success', 'Marca editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao editar uma marca: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar marca. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $brand = Brand::findOrFail($id);
            $brand->delete();
            DB::commit();
            return redirect()->route('brands.index')->with('success', 'Marca apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar uma marca: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar marca. Contate o suporte para saber mais sobre.');
        }
    }
}
