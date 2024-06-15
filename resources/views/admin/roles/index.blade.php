@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Funções</h4>
        <p>As funções, além de organizar os papéis de cada usuário, também são responsáveis por delegar o acesso de cada
            área do sistema (através das permissões).</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create role')
            <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Criar função</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todas as funções cadastradas
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
                @foreach ($roles as $role)
                    @if ($role->name != 'Super Admin' && $role->name != 'Admin' && $role->name != 'Cliente')
                        <tr class="align-middle text-center">
                            <td>
                                {{ $role->name }}
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                    @can('list permissions')
                                        <a href="{{ route('permissions.index', ['role_id' => $role->id]) }}"
                                            class="btn btn-sm btn-info" title="Listar permissões">
                                            <i class="fa-solid fa-person-booth"></i>
                                        </a>
                                    @endcan
                                    @can('edit role')
                                        <a href="{{ route('roles.edit', ['id' => $role->id]) }}" class="btn btn-sm btn-warning"
                                            title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    @endcan
                                    @can('destroy role')
                                        <form id="formDelete{{ $role->id }}"
                                            action="{{ route('roles.destroy', ['id' => $role->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                data-delete-id="{{ $role->id }}" title="Apagar">
                                                <i class="fa-solid fa-eraser"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
