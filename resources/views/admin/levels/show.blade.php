@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Níveis para clientes</h4>
        <p>
            Muita atenção ao arquitetar os níveis para seus clientes, pois haverão os descontos sobre as compras dos
            clientes de acordo com o que for definido aqui. Lembre-se que, caso um produto esteja em promoção, os descontos
            irão somar, por isso defina os valores de desconto com cuidado.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit level')
            <a href="{{ route('levels.edit', ['id' => $level->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list levels')
            <a href="{{ route('levels.index') }}" class="btn btn-sm btn-primary">Listar níveis</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Detalhes deste nível para clientes
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome/Apelido</h6>
                        <p class="card-text">{{ $level->name }}</p>
                        <h6 class="card-title fw-bold">Descrição explicativa visível</h6>
                        <p class="card-text">{{ $level->description }}</p>
                        <h6 class="card-title fw-bold">Desconto que este nível dispõe</h6>
                        <p class="card-text">{{ $level->discount }}</p>
                        <h6 class="card-title fw-bold">Qtd. de clientes relacionados</h6>
                        <p class="card-text">{{ $totalClients }}</p>
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($level->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($level->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
