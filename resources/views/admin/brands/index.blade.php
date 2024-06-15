@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Marcas</h4>
        <p>As marcas possuem o propósito organizacional fornecendo a origem de determinado código de fabricante que houver
            em um produto. Só será possível apagar uma marca caso não haja nenhum produto relacionado com a mesma. Não é
            possível apagar ou editar a marca GENUINE PARTS (ORIGINAL) que está presente por padrão.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create brand')
            <a href="{{ route('brands.create') }}" class="btn btn-sm btn-primary">Criar marca</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos as marcas cadastradas
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nome</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $brand->name }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show brand')
                                    <a href="{{ route('brands.show', ['id' => $brand->id]) }}" class="btn btn-sm btn-info"
                                        title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @if ($brand->id > 2)
                                    @can('edit brand')
                                        <a href="{{ route('brands.edit', ['id' => $brand->id]) }}"
                                            class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                @endif
                                @if ($brand->id > 2 && $brand->products->count() == 0)
                                    @can('destroy brand')
                                        <form id="formDelete{{ $brand->id }}"
                                            action="{{ route('brands.destroy', ['id' => $brand->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                title="Apagar" data-delete-id="{{ $brand->id }}">
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
