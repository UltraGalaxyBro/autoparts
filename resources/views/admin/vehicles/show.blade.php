@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Veículos</h4>
        <p>São essenciais para a funcionalidade de registrar corridas, pois toda corrida deve possuir um veículo em uso.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit vehicle')
            <a href="{{ route('vehicles.edit', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list vehicles')
            <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-secondary">Listar veículos</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Detalhes do veículo
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome/modelo</h6>
                        <p class="card-text">{{ $vehicle->name }}</p>
                        <h6 class="card-title fw-bold">Tipo</h6>
                        <p class="card-text">{{ $vehicle->type }}</p>
                        <h6 class="card-title fw-bold">Placa</h6>
                        <p class="card-text">{{ $vehicle->license_plate }}</p>
                        <h6 class="card-title fw-bold">Corridas efetuadas com sucesso</h6>
                        <p class="card-text">{{ $quantityRaces }}</p>
                        <h6 class="card-title fw-bold">Total de quilômetros percorridos aproximadamente</h6>
                        <p class="card-text">{{ number_format($totalDistance, 2, ',', '.') }} km</p>
                        <br>
                        <h6 class="card-title fw-bold">Registrado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($vehicle->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($vehicle->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
