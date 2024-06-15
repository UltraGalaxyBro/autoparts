@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Marcas</h4>
        <p>As marcas possuem o propósito organizacional fornecendo a origem de determinado código de fabricante que houver
            em um produto.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit brand')
            <a href="{{ route('brands.edit', ['id' => $brand->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list brands')
            <a href="{{ route('brands.index') }}" class="btn btn-sm btn-secondary">Listar marcas</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Detalhes da marca
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome</h6>
                        <p class="card-text">{{ $brand->name }}</p>
                        <h6 class="card-title fw-bold">Qtd. de produtos relacionados</h6>
                        <p class="card-text">{{ $productsRelated }}</p>
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($brand->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($brand->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
