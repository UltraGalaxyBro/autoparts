<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Models\SupplierContact;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list suppliers', ['only' => ['index']]);
        $this->middleware('permission:create supplier', ['only' => ['create']]);
        $this->middleware('permission:show supplier', ['only' => ['show']]);
        $this->middleware('permission:edit supplier', ['only' => ['edit']]);
        $this->middleware('permission:destroy supplier', ['only' => ['destroy']]);

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::orderByDesc('created_at')->get();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {

        $request->validated();

        DB::beginTransaction();

        try {

            $supplier = Supplier::create([
                'name' => $request->name,
            ]);

            if (isset($request->contacts) && $request->contacting === 'Sim') {
                foreach ($request->contacts as $contactData) {
                    $whatsappSign = isset($contactData['whatsapp']) && $contactData['whatsapp'] === 'on' ? true : false;
                    SupplierContact::create([
                        'supplier_id' => $supplier->id,
                        'name' => $contactData['name'],
                        'telephone' => $contactData['telephone'],
                        'celphone' => $contactData['celphone'],
                        'whatsapp' => $whatsappSign,
                        'email' => $contactData['email'],
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Fornecedor criado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao criar fornecedor: ' . $e);
            return redirect()->back()->with('error', 'Erro ao criar fornecedor. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::with('supplierContacts')->findOrFail($id);
        return view('admin.suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $supplier = Supplier::with('supplierContacts')->findOrFail($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, string $id)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->name = $request->name;
            $supplier->save();

            if (isset($request->contacts) && $request->contacting === 'Sim') {
                SupplierContact::where('supplier_id', $id)->delete();
                foreach ($request->contacts as $contactData) {
                    $whatsappSign = isset($contactData['whatsapp']) && $contactData['whatsapp'] === 'on' ? true : false;
                    SupplierContact::create([
                        'supplier_id' => $supplier->id,
                        'name' => $contactData['name'],
                        'telephone' => $contactData['telephone'],
                        'celphone' => $contactData['celphone'],
                        'whatsapp' => $whatsappSign,
                        'email' => $contactData['email'],
                    ]);
                }
            }
            //$supplier->update($request->validated());
            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Fornecedor editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao editar fornecedor: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar fornecedor. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();
            DB::commit();
            return redirect()->route('suppliers.index')->with('success', 'Fornecedor apagado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar fornecedor: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar fornecedor. Contate o suporte para saber mais sobre.');
        }
    }
}
