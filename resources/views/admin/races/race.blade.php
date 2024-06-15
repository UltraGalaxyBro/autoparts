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
                PERMITA SUA LOCALIZAÇÃO SEMPRE.
            </small>
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list races')
            <a href="{{ route('races.index') }}" title="Listar corridas" class="btn btn-sm btn-secondary">Listar corridas</a>
        @endcan
    </div>
    <div class="mb-1">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h5 class="text-center text-dark bg-white rounded p-2">
                    Dados da corrida ativa desde
                    às<br><strong>{{ \Carbon\Carbon::parse($race->departure_time)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}</strong>
                </h5>
            </div>
        </div>
    </div>
    <div class="mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4 text-center">
                @if (count($raceStops) > 0)
                    <ol class="list-group list-group-numbered">
                        @foreach ($raceStops as $raceStop)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $raceStop->name }}</div>
                                    <span class="badge text-bg-primary"><i class="fa-regular fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($raceStop->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                                    </span>
                                    <span class="badge text-bg-primary"><i
                                            class="fa-solid fa-arrows-left-right-to-line"></i> {{ $raceStop->distance }}
                                        Km</span>
                                </div>
                            </li>
                        @endforeach
                    </ol>
                @else
                    <h6 class="text-secondary">
                        Nenhuma parada registrada.<br>Chegue ao objetivo e adicione a primeira parada.
                    </h6>
                @endif
            </div>
        </div>
        <div class="row justify-content-center mt-3">
            <div class="col-md-6 text-center">
                @if (count($raceStops) > 0)
                    @php
                        $order = $raceStops->count();
                    @endphp
                    <div class="row justify-content-center mt-1">
                        <div class="col-md-6 mb-2">
                            <button class="btn btn-info" type="button" data-bs-toggle="modal"
                                data-bs-target="#modalNameStop">
                                Registrar {{ $order + 1 }}ª parada <i class="fa-regular fa-compass"></i>
                            </button>
                        </div>
                        <div class="col-md-4 mb-2">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                data-bs-target="#modalObservationRace">Finalizar corrida</button>
                        </div>
                    </div>
                @else
                    <button type="button" class="btn btn-lg btn-info mb-2" data-bs-toggle="modal"
                        data-bs-target="#modalNameStop">
                        Registrar 1ª parada <i class="fa-regular fa-compass"></i>
                    </button>
                @endif
            </div>
        </div>
    </div>

    <x-modal-name-stop :$race />
    @if (count($raceStops) > 0)
        <x-modal-observation-race :$race />
    @endif
@endsection
