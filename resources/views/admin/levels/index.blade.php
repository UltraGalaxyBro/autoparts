@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Níveis para clientes</h4>
        <p>
            Muita atenção ao arquitetar os níveis para seus clientes, pois haverão os descontos sobre as compras dos
            clientes de acordo com o que for definido aqui. Por padrão deve haver ao menos um nível cadastrado.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create level')
            <a href="{{ route('levels.create') }}" class="btn btn-sm btn-primary">Cadastrar nível para clientes</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos os níveis cadastrados
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nome/Apelido</th>
                    <th class="text-center">Desconto que é aplicado (%)</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($levels as $level)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $level->name }}
                        </td>
                        <td>
                            {{ $level->discount }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show level')
                                    <a href="{{ route('levels.show', ['id' => $level->id]) }}" class="btn btn-sm btn-info"
                                        title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @can('edit level')
                                    <a href="{{ route('levels.edit', ['id' => $level->id]) }}" class="btn btn-sm btn-warning"
                                        title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endcan
                                @if ($level->id > 1)
                                    @can('destroy level')
                                        <form id="formDelete{{ $level->id }}"
                                            action="{{ route('levels.destroy', ['id' => $level->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                data-delete-id="{{ $level->id }}" title="Apagar">
                                                <i class="fa-solid fa-eraser"></i>
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
