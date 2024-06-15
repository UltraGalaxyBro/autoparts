@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Veículos</h4>
        <p>São essenciais para a funcionalidade de registrar corridas, pois toda corrida deve possuir um veículo em uso.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list races')
            <a href="{{ route('races.index') }}" class="btn btn-sm btn-secondary">Voltar à página das corridas</a>
        @endcan
        @can('create vehicle')
            <a href="{{ route('vehicles.create') }}" class="btn btn-sm btn-primary">Cadastrar veículo</a>
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
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Placa</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehicles as $vehicle)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $vehicle->name }}
                        </td>
                        <td>
                            {{ $vehicle->type }}
                        </td>
                        <td>
                            {{ $vehicle->license_plate }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                <a href="{{ route('vehicles.show', ['id' => $vehicle->id]) }}" class="btn btn-sm btn-info"
                                    title="Visualizar detalhes">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('vehicles.edit', ['id' => $vehicle->id]) }}"
                                    class="btn btn-sm btn-warning" title="Editar">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                @can('destroy vehicle')
                                    @if ($vehicle->races->count() == 0)
                                        <form id="formDelete{{ $vehicle->id }}"
                                            action="{{ route('vehicles.destroy', ['id' => $vehicle->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                title="Apagar" data-delete-id="{{ $vehicle->id }}">
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
