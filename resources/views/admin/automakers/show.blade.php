@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Montadoras</h4>
        <p>As montadoras, além do propósito de auxiliar na organização e indicar a compatibilidade do veículo, são
            essenciais para construir o código interno de um
            produto.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit automaker')
            <a href="{{ route('automakers.edit', ['id' => $automaker->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list automakers')
            <a href="{{ route('automakers.index') }}" class="btn btn-sm btn-secondary">Listar montadoras</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Detalhes da montadora
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome</h6>
                        <p class="card-text">{{ $automaker->name }}</p>
                        <h6 class="card-title fw-bold">Participação no código interno</h6>
                        <p class="card-text"><img src="{{ asset('img/logo.svg') }}" width="25px" height="25px"
                                alt="Logo">
                            CO2-<span class="text-danger">XX</span><span id="showingShardCode" class="badge bg-primary"
                                style="font-size: 15px;">{{ $automaker->shard_code }}</span><span
                                class="text-danger">XXX</span></p>
                        <h6 class="card-title fw-bold">Qtd. de produtos relacionados</h6>
                        <p class="card-text">{{ $productsRelated }}</p>
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($automaker->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($automaker->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
