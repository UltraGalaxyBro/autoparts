@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Montadoras</h4>
        <p>As montadoras, além do propósito de auxiliar na organização e indicar a compatibilidade do veículo, são
            essenciais para construir o código interno de um
            produto. Não é possível apagar ou editar as 9 montadoras que estão presentes por padrão.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create automaker')
            <a href="{{ route('automakers.create') }}" class="btn btn-sm btn-primary">Criar montadora</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos as montadoras cadastradas
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    {{-- <th class="text-center"><i class="fa-solid fa-image"></i></th> --}}
                    <th class="text-center">Nome</th>
                    <th class="text-center"><small>Parte em código interno</small></th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($automakers as $automaker)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $automaker->name }}
                        </td>
                        <td>
                            <img src="{{ asset('img/logo.svg') }}" width="25px" height="25px" alt="Logo">
                            CO2-<span id="showingShardCode" class="text-secondary">XX</span><span class="badge bg-primary"
                                style="font-size: 15px;">{{ $automaker->shard_code }}</span><span
                                class="text-secondary">XXX</span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show automaker')
                                    <a href="{{ route('automakers.show', ['id' => $automaker->id]) }}"
                                        class="btn btn-sm btn-info" title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @if ($automaker->id > 9 && $automaker->products->count() == 0)
                                    @can('edit automaker')
                                        <a href="{{ route('automakers.edit', ['id' => $automaker->id]) }}"
                                            class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('destroy automaker')
                                        <form id="formDelete{{ $automaker->id }}"
                                            action="{{ route('automakers.destroy', ['id' => $automaker->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                data-delete-id="{{ $automaker->id }}" title="Apagar">
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
