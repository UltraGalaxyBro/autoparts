<?php

namespace App\Http\Controllers;

use App\Http\Requests\VehicleRequest;
use App\Models\Race;
use App\Models\Vehicle;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VehicleController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list vehicles', ['only' => ['index']]);
        $this->middleware('permission:create vehicle', ['only' => ['create']]);
        $this->middleware('permission:show vehicle', ['only' => ['show']]);
        $this->middleware('permission:edit vehicle', ['only' => ['edit']]);
        $this->middleware('permission:destroy vehicle', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            Vehicle::create($request->all());
            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Veículo registrado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro apresentado ao criar veículo. Segue o erro: ' . $e);
            return redirect()->back()->with('error', 'Erro ao registrar veículo. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);

        $quantityRaces = Race::where('vehicle_id', $id)->where('status', 'CONCLUÍDA')->count();
        $totalDistance = Race::where('vehicle_id', $id)->where('status', 'CONCLUÍDA')->sum('total_distance');
        return view('admin.vehicles.show', compact('vehicle', 'quantityRaces', 'totalDistance'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, string $id)
    {
        $request->validated();

        DB::beginTransaction();

        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($request->all());
            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Veículo editado com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro apresentado ao editar veículo. Segue o erro: ' . $e);
            return redirect()->back()->with('error', 'Erro ao editar veículo. Contate o suporte para saber mais sobre.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->delete();
            DB::commit();
            return redirect()->route('vehicles.index')->with('success', 'Veículo apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Tentativa ao apagar um veículo: ' . $e);
            return redirect()->back()->with('error', 'Erro ao apagar veículo. Contate o suporte para saber mais sobre.');
        }
    }
}
