@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Fornecedores</h4>
        <p>É importante registrar os fornecedores a título de organização na criação de um produto. Fornecedores estão
            vinculados a localização de um produto, visto que pode haver fornecedores em alguns locais, mas também não.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create supplier')
            <a href="{{ route('suppliers.create') }}" class="btn btn-sm btn-primary">Criar fornecedor</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos os fornecedores cadastrados
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
                @foreach ($suppliers as $supplier)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $supplier->name }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show supplier')
                                    <a href="{{ route('suppliers.show', ['id' => $supplier->id]) }}" class="btn btn-sm btn-info"
                                        title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @can('edit supplier')
                                    <a href="{{ route('suppliers.edit', ['id' => $supplier->id]) }}"
                                        class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endcan
                                @can('destroy supplier')
                                    @if ($supplier->id > 1)
                                        <form id="formDelete{{ $supplier->id }}"
                                            action="{{ route('suppliers.destroy', ['id' => $supplier->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                title="Apagar" data-delete-id="{{ $supplier->id }}">
                                                <i class="fa-solid fa-eraser"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
