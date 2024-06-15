@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Corridas</h4>
        <p>
            <small>
                Nesta área são registradas as corridas efetuadas pelos motoristas, sejam em entregas ou coletas. Sempre
                que
                chegar em um dos destinos, o motorista precisa sinalizar sua chegada. Ao concluir uma corrida, que se trata
                de
                sair de uma unidade da CO2 Peças e retornar para a mesma ao final, tal corrida é finalizada. Não é possível
                iniciar uma corrida caso haja outra EM ANDAMENTO.
            </small>
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @if ($race->status == 'EM ANDAMENTO' && (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Admin')))
            <a href="{{ route('races.race', ['id' => $race->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endif
        @can('list races')
            <a href="{{ route('races.index') }}" title="Listar corridas" class="btn btn-sm btn-secondary">Listar corridas</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            @if ($race->status == 'EM ANDAMENTO' && (!auth()->user()->hasRole('Super Admin') && !auth()->user()->hasRole('Admin')))
                Corrida ainda em andamento. Lembre-se de fazer toda a corrida e depois finaliza-la!
            @elseif ($race->status == 'CONCLUÍDA')
                Corrida concluída com sucesso!
            @else
                O motorista ainda está efetuando esta corrida
            @endif
        </h5>
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        Detalhes da corrida
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div id="map" style="height: 300px; width: 100%;"></div>
                        </div>
                        <ul class="list-group list-group-horizontal-md mb-2 mt-5">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Momento da partida</div>
                                    {{ \Carbon\Carbon::parse($race->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Momento da chegada</div>
                                    @if ($race->arrival_time)
                                        {{ \Carbon\Carbon::parse($race->arrival_time)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                                    @else
                                        A corrida ainda não foi finalizada
                                    @endif
                                </div>
                            </li>
                        </ul>
                        <ul class="list-group list-group-horizontal-md mb-2">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Motorista/piloto desta corrida</div>
                                    {{ $race->user->name }}
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Veículo utilizado</div>
                                    {{ $race->vehicle->name }}
                                </div>
                            </li>
                            @if ($race->total_distance)
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Distância aproximada percorrida no total</div>
                                        {{ $race->total_distance }} Km
                                    </div>
                                </li>
                            @endif
                        </ul>
                        @if ($race->observation != null)
                            <ul class="list-group list-group-horizontal-md mb-2">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Observação pelo motorista sobre a corrida:</div>
                                        {{ $race->observation }}
                                    </div>
                                </li>
                            </ul>
                        @endif
                        <div class="card-header text-center">
                            Paradas
                        </div>
                        <ol class="list-group text-center mb-2">
                            @foreach ($raceStops as $raceStop)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">{{ $raceStop->name }}</div>
                                        <span class="badge text-bg-primary"><i class="fa-regular fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($raceStop->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                                        </span>
                                        <span class="badge text-bg-primary"><i
                                                class="fa-solid fa-arrows-left-right-to-line"></i>
                                            {{ $raceStop->distance }}
                                            Km</span>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
