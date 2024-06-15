<?php

namespace App\Http\Controllers;

use App\Models\Headquarter;
use App\Models\Race;
use App\Models\RaceStop;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RaceController extends Controller
{
    //VALIDANDO SE O USUÁRIO POSSUI AS PERMISSÕES NECESSÁRIAS PARA ACESSAR ESTA CONTROLLER
    public function __construct()
    {
        $this->middleware('auth'); //Verificando se o usuário está loggado
        //Verificando as permissões deste usuário
        $this->middleware('permission:list races', ['only' => ['index']]);
        $this->middleware('permission:begin race', ['only' => ['begin']]);
        $this->middleware('permission:show race', ['only' => ['show']]);
        $this->middleware('permission:destroy race', ['only' => ['destroy']]);
    }

    //FUNÇÃO PARA CALCULAR A DISTÂNCIA ENTRE AS COORDENADAS
    public function calculoHarvesine($latitude1, $longitude1, $latitude2, $longitude2)
    {
        // Raio da Terra em quilômetros
        define('RAIO_TERRA', 6371);

        // Convertendo graus para radianos
        $latitude1 = deg2rad($latitude1);
        $longitude1 = deg2rad($longitude1);
        $latitude2 = deg2rad($latitude2);
        $longitude2 = deg2rad($longitude2);

        // Diferença entre as longitudes e latitudes
        $deltaLatitude = $latitude2 - $latitude1;
        $deltaLongitude = $longitude2 - $longitude1;

        // Aplicando a fórmula de Haversine
        $a = sin($deltaLatitude / 2) * sin($deltaLatitude / 2) + cos($latitude1) * cos($latitude2) * sin($deltaLongitude / 2) * sin($deltaLongitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distancia = RAIO_TERRA * $c;

        // Retornando a distância
        return $distancia;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        if ($user->hasRole('Super Admin') || $user->hasRole('Admin')) {
            $races = Race::orderBy('updated_at', 'desc')->get();
        } else {
            $races = Race::where('user_id', $user->id)->orderBy('updated_at', 'desc')->get();
        }
        $headquarters = Headquarter::get();
        $availableVehicles = Race::where('status', 'EM ANDAMENTO')->pluck('vehicle_id')->toArray();
        $vehicles = Vehicle::whereNotIn('id', $availableVehicles)->get();

        return view('admin.races.index', compact('races', 'headquarters', 'vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function begin(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'headquarter_id' => 'required',
            'vehicle_id' => 'required'
        ], [
            'user_id.required' => 'Necessário que haja um usuário loggado.',
            'headquarter_id.required' => 'Necessário que haja uma unidade de loja selecionada.',
            'vehicle_id.required' => 'Selecione o veículo que irá participar desta corrida.'
        ]);

        $request->merge([
            'departure_time' => Carbon::now()->toDateTimeString(), //COLOCAR A DATA E HORÁRIO DE AGORA
            'status' => 'EM ANDAMENTO'
        ]);

        DB::beginTransaction();

        try {
            $race = Race::create($request->all());
            $id = $race->id; //Recuperando ID recém criado. Vou utilizar no redirecionamento.
            DB::commit();
            return redirect()->route('races.race', ['id' => $id])->with('info', 'Sua corrida foi iniciada! Quando chegar em alguma parada, registre-a.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao tentar iniciar uma corrida. Erro apresentado: ' . $e);
            return redirect()->back()->with('error', 'Aconteceu algum erro inesperado ao tentar iniciar o registro de uma corrida. Contate o suporte para saber mais sobre!');
        }
    }

    public function race(string $id)
    {
        $raceStops = RaceStop::where('race_id', $id)->get();
        $race = Race::findOrFail($id);
        return view('admin.races.race', compact('race', 'raceStops'));
    }

    public function addStop(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'latitude' => 'required',
                'longitude' => 'required'
            ],
            [
                'name.required' => 'Tente registrar a parada novamente, mas desta vez informando qual o nome do local.',
                'latitude.required' => 'É necessário que este aparelho permita obter sua localização.',
                'longitude.required' => 'É necessário que este aparelho permita obter sua localização.'
            ]
        );
        //dd($request);
        if (!RaceStop::where('race_id', $id)->count() > 0) {
            $race = Race::findOrFail($id);
            $headquarter = Headquarter::where('id', $race->headquarter_id)->first();
            $coordinates = explode(',', $headquarter->coordinates);
            $latitude = $coordinates[0];
            $longitude = $coordinates[1];

            $distanceBrute = $this->calculoHarvesine($latitude, $longitude, $request->latitude, $request->longitude);
            $distance = number_format($distanceBrute, 3);
        } else {
            $lastStop = RaceStop::where('race_id', $id)->orderBy('created_at', 'desc')->first();
            $distanceBrute = $this->calculoHarvesine($lastStop->latitude, $lastStop->longitude, $request->latitude, $request->longitude);
            $distance = number_format($distanceBrute, 3);
        }

        $request->merge(['distance' => $distance]);

        DB::beginTransaction();

        try {
            $request->merge(['race_id' => $id]);
            RaceStop::create($request->all());
            DB::commit();
            return redirect()->route('races.race', ['id' => $id])->with('success', 'Parada registrada!.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao tentar registrar uma parada de corrida. Erro apresentado: ' . $e);
            return redirect()->back()->with('error', 'Aconteceu algum erro inesperado ao tentar registrar uma parada da corrida. Contate o suporte para saber mais sobre!');
        }
    }

    public function removeStop(string $id)
    {
    }

    public function finish(Request $request, string $id)
    {
        $allStops = RaceStop::where('race_id', $id)->get();
        $totalDistance = $allStops->sum('distance');
        $lastStop = RaceStop::where('race_id', $id)->orderBy('created_at', 'desc')->first();
        $race = Race::findOrFail($id);
        $headquarter = Headquarter::findOrFail($race->headquarter_id);
        $coordinates = explode(',', $headquarter->coordinates);

        $latitude = $coordinates[0];
        $longitude = $coordinates[1];
        $wayToHeadquarter = $this->calculoHarvesine($lastStop->latitude, $lastStop->longitude, $latitude, $longitude);

        $totalDistance += $wayToHeadquarter;
        $totalDistance = number_format($totalDistance, 3);

        $request->merge([
            'arrival_time' => Carbon::now()->toDateTimeString(),
            'status' => 'CONCLUÍDA',
            'total_distance' => $totalDistance
        ]);

        DB::beginTransaction();

        try {
            $race = Race::findOrFail($id);
            $race->update($request->all());

            DB::commit();
            return redirect()->route('races.index')->with('success', 'Corrida finalizada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro ao tentar finalizar a corrida. Erro apresentado: ' . $e);
            return redirect()->back()->with('error', 'Aconteceu algum erro inesperado ao tentar finalizar a corrida. Contate o suporte para saber mais sobre!');
        }
    }

    public function show(string $id)
    {
        $race = Race::findOrFail($id);
        if ($race->arrival_time == null) {
            $begin = \Carbon\Carbon::parse($race->created_at)
                ->tz('America/Sao_Paulo')
                ->format('H:i:s');
            $times = 'Início: ' . $begin;
        } else {
            $begin = \Carbon\Carbon::parse($race->created_at)
                ->tz('America/Sao_Paulo')
                ->format('H:i:s');
            $end = \Carbon\Carbon::parse($race->arrival_time)
                ->tz('America/Sao_Paulo')
                ->format('H:i:s');
            $times = 'Início: ' . $begin . '<br>Fim: ' . $end;
        }

        $headquarter = Headquarter::where('id', $race->headquarter_id)->first();
        $coordinates = explode(',', $headquarter->coordinates);

        $latitude = $coordinates[0];
        $longitude = $coordinates[1];

        $raceStops = RaceStop::where('race_id', $race->id)->get();
        $markers = [];
        $co2Marker = [
            'coordinates' => [$latitude, $longitude],
            'popupText' => '<strong>unidade CO2 Peças</strong><br>' . $times,
            'isCO2' => true
        ];
        $markers[] = $co2Marker;
        foreach ($raceStops as $stop) {
            $stopped_at = Carbon::parse($stop->created_at)->format('H:i:s');
            $markers[] = [
                'coordinates' => [$stop->latitude, $stop->longitude],
                'popupText' => '<strong>' . $stop->name . '</strong><br><small>chegada às</small> ' . $stopped_at . '<br><small>Distância: ' . $stop->distance . ' km</small>',
                'isCO2' => false
            ];
        }
       // dd($markers);
        return view('admin.races.show', compact('race', 'raceStops', 'markers'));
    }

    public function destroy(string $id)
    {
        $race = Race::findOrFail($id);
        DB::beginTransaction();
        try {
            $race->delete();
            DB::commit();
            return redirect()->route('races.index')->with('success', 'Corrida apagada com sucesso!');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Erro apresentado ao tentar excluir uma corrida. Segue o erro: ' . $e);
            return redirect()->back()->with('error', 'Aconteceu algum erro inesperado ao tentar apagar a corrida. Contate o suporte para saber mais sobre!');
        }
    }
}
