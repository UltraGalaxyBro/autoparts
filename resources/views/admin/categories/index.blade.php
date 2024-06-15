@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Categorias</h4>
        <p>As categorias, além do propósito de auxiliar na organização, são essenciais para construir o código interno de um
            produto. Só será possível apagar uma categoria caso não haja nenhum produto relacionado com a mesma. Não é
            possível apagar as 50 categorias que estão presentes por padrão.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create category')
            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-primary">Criar categoria</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos as categorias cadastradas
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nome</th>
                    <th class="text-center"><small>Parte em código interno</small></th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            <img src="{{ asset('img/logo.svg') }}" width="25px" height="25px" alt="Logo"> CO2-<span
                                id="showingShardCode" class="badge bg-primary"
                                style="font-size: 15px;">{{ $category->shard_code }}</span><span
                                class="text-secondary">XXXXX</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show category')
                                    <a href="{{ route('categories.show', ['id' => $category->id]) }}"
                                        class="btn btn-sm btn-info" title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @if ($category->id > 50 && $category->products->count() == 0)
                                    @can('edit category')
                                        <a href="{{ route('categories.edit', ['id' => $category->id]) }}"
                                            class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('destroy category')
                                        <form id="formDelete{{ $category->id }}"
                                            action="{{ route('categories.destroy', ['id' => $category->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                data-delete-id="{{ $category->id }}" title="Apagar">
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
