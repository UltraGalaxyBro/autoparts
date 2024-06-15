<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetRequest;
use App\Models\Budget;
use App\Models\BudgetItem;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list budgets', ['only' => ['index']]);
        $this->middleware('permission:create budget', ['only' => ['create']]);
        $this->middleware('permission:show budget', ['only' => ['show']]);
        $this->middleware('permission:edit budget', ['only' => ['edit']]);
        $this->middleware('permission:destroy budget', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            $budgets = Budget::orderBy('updated_at', 'desc')->get();
        } else {
            $budgets = Budget::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
        }

        return view('admin.budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sellers = User::whereHas('roles.permissions', function ($query) {
            $query->whereIn('name', ['list budgets', 'create budget', 'show budget', 'edit budget', 'destroy budget']);
        })->get();
        $clients = Customer::get();
        $suppliers = Supplier::get();
        $specialSuppliers = Supplier::where('name', 'like', '%\*%')->get();
        return view('admin.budgets.create', compact('sellers', 'clients', 'suppliers', 'specialSuppliers'));
    }

    public function clone(string $id)
    {
        $budgetItems = BudgetItem::where('budget_id', $id)->get();
        $budget_id = $id;
        $sellers = User::whereHas('roles.permissions', function ($query) {
            $query->whereIn('name', ['list budgets', 'create budget', 'show budget', 'edit budget', 'destroy budget']);
        })->get();
        $clients = Customer::get();
        $suppliers = Supplier::get();
        $specialSuppliers = Supplier::where('name', 'like', '%\*%')->get();
        return view('admin.budgets.clone', compact('budgetItems', 'budget_id', 'sellers', 'clients', 'suppliers', 'specialSuppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {

            $request->merge([
                'status' => 'CONCLUÍDA'
            ]);

            $budget = Budget::create($request->all());
            foreach ($request->products as $productData) {
                BudgetItem::create([
                    'budget_id' => $budget->id,
                    'description' => $productData['description'],
                    'supplier_id' => $productData['supplier_id'],
                    'supplier_reference' => $productData['supplier_reference'],
                    'cost' => $productData['cost'],
                    'deadline' => $productData['deadline'],
                    'price' => $productData['price'],
                    'quantity' => $productData['quantity'],
                ]);
            }

            DB::commit();
            return redirect()->route('budgets.show', ['id' => $budget->id])->with('success', 'Cotação gerada com sucesso!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Erro ao criar cotação. Segue o erro apresentado: ' . $e);
            return back()->withInput()->with('error', 'Erro ocorrido na tentativa de gerar a cotação. Consulte o suporte para saber mais sobre!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $budget = Budget::findOrFail($id);
        $budgetItems = BudgetItem::where('budget_id', $budget->id)->get();
        return view('admin.budgets.show', compact('budget', 'budgetItems'));
    }

    public function generatePdf(Request $request)
    {

        $request->validate(
            [
                'budget_id' => 'required'
            ],
            [
                'budget_id.required' => 'Algo deu errado no momento em que foi gerar a cotação por não ter o ID capturado da mesma. Contate o suporte!'
            ]
        );

        $budget = Budget::findOrFail($request->budget_id);
        $budgetItems = BudgetItem::where('budget_id', $budget->id)->get();
        $pdf = Pdf::loadView('admin.budgets.pdf', ['budget' => $budget, 'budgetItems' => $budgetItems])->setPaper('a4', 'portrait');
        return $pdf->download('cotaçãoID_' . str_pad($budget->id, 4, '0', STR_PAD_LEFT) . '.pdf');
    }

    public function reportItems(Request $request)
    {

        $request->validate(
            [
                'selectedBudgetItemsIds' => 'required',
                'budget_id' => 'required'

            ],
            [
                'selectedBudgetItemsIds.required' => 'Necessário haver pelo menos um item da cotação selecionado.',
                'budget_id.required' => 'Algo deu errado no momento em que foi gerar o relatório com os itens selecionados por conta da ausência do ID da cotação. Contate o suporte!'

            ]
        );

        
        $budget = Budget::findOrFail($request->budget_id);
        $budgetItems = BudgetItem::whereIn('id', $request->selectedBudgetItemsIds)->get();
       
        $pdf = Pdf::loadView('admin.budgets.report-pdf', ['budget' => $budget, 'budgetItems' => $budgetItems])->setPaper('a4', 'portrait');
        return $pdf->download('produtos_da_cotação_de_ID_' . str_pad($budget->id, 4, '0', STR_PAD_LEFT) . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $budget = Budget::findOrFail($id);

        $budgetItems = BudgetItem::where('budget_id', $budget->id)->get();
        $sellers = User::whereHas('roles.permissions', function ($query) {
            $query->whereIn('name', ['list budgets', 'create budget', 'show budget', 'edit budget', 'destroy budget']);
        })->get();
        $clients = Customer::get();
        $suppliers = Supplier::get();
        $specialSuppliers = Supplier::where('name', 'like', '%\*%')->get();
        return view('admin.budgets.edit', compact('budget', 'budgetItems', 'sellers', 'clients', 'suppliers', 'specialSuppliers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetRequest $request, string $id)
    {
        $request->validated();

        $budget = Budget::findOrFail($id);

        DB::beginTransaction();

        try {

            $budget->update($request->all());

            $budget->budgetItems()->delete();

            foreach ($request->products as $productData) {
                BudgetItem::create([
                    'budget_id' => $budget->id,
                    'description' => $productData['description'],
                    'supplier_id' => $productData['supplier_id'],
                    'supplier_reference' => $productData['supplier_reference'],
                    'cost' => $productData['cost'],
                    'deadline' => $productData['deadline'],
                    'price' => $productData['price'],
                    'quantity' => $productData['quantity'],
                ]);
            }

            DB::commit();
            return redirect()->route('budgets.show', ['id' => $budget->id])->with('success', 'Cotação editada com sucesso!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Erro ao editar cotação. Segue o erro apresentado: ' . $e);
            return back()->withInput()->with('error', 'Erro ocorrido na tentativa de editar a cotação. Consulte o suporte para saber mais sobre!');
        }
    }

    public function transform(Request $request, string $id)
    {
        $request->validate(
            [
                'sign_status' => 'required'
            ],
            [
                'sign_status.required' => 'O status atual desta cotação não está sendo capturado no formulário. Consulte o suporte para saber sobre!'
            ]
        );

        $budget = Budget::findOrFail($id);

        DB::beginTransaction();

        try {

            if ($request->sign_status == 'VENDIDA') {
                $request->merge([
                    'status' => 'CONCLUÍDA'
                ]);
            } else {
                $request->merge([
                    'status' => 'VENDIDA'
                ]);
            }

            $budget->update($request->all());

            DB::commit();
            return redirect()->route('budgets.show', ['id' => $id])->with('success', 'Cotação transformada com sucesso!');
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Erro ao trasnformar o status da cotação. Segue o erro apresentado: ' . $e);
            return back()->with('error', 'Erro ocorrido na tentativa de transformar o status da cotação. Consulte o suporte para saber mais sobre!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $budget = Budget::findOrFail($id);
            $budget->delete();

            DB::commit();
            return redirect()->route('budgets.index')->with('success', 'Cotação apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar uma cotação: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar cotação. Contate o suporte para saber mais sobre.');
        }
    }
}
