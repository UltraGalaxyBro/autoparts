<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list categories', ['only' => ['index']]);
        $this->middleware('permission:create category', ['only' => ['create']]);
        $this->middleware('permission:show category', ['only' => ['show']]);
        $this->middleware('permission:edit category', ['only' => ['edit']]);
        $this->middleware('permission:destroy category', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        DB::beginTransaction();

        try {
            $request->validated();
            Category::create($request->all());
            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Categoria cadastrada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao criar uma categoria: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar categoria. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::findOrFail($id);
        $productsRelated = Product::where('category_id', $id)->count();
        return view('admin.categories.show', compact('category', 'productsRelated'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);
            $category->update($request->validated());
            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Categoria editada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao editar uma categoria: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar categoria. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $category = Category::findOrFail($id);
            $category->delete();
            DB::commit();
            return redirect()->route('categories.index')->with('success', 'Categoria apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar uma categoria: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar categoria. Contate o suporte para saber mais sobre.');
        }
    }
}
