@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Usuários</h4>
        <p>Os usuários podem ser aqueles que utilizam o sistema da CO2 Peças ou mesmo os que visitam o e-commerce. Existem
            níveis e cargos diferentes de usuários. É importante se atentar para quem você dará as permissões de acesso para
            determinadas áreas do sistema.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create user')
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Criar usuário</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos os usuários cadastrados
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Nome</th>
                    <th class="text-center">E-mail</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    @if ($user->id != Auth::user()->id)
                        @if (Auth::user()->hasRole('Admin') && !$user->hasRole('Super Admin'))
                            <tr class="align-middle text-center">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                        <a href="{{ route('users.show', ['id' => $user->id]) }}" class="btn btn-sm btn-info"
                                            title="Visualizar detalhes">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}"
                                            class="btn btn-sm btn-warning" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                        <form id="formDelete{{ $user->id }}"
                                            action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit"
                                                class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                data-delete-id="{{ $user->id }}" title="Apagar">
                                                <i class="fa-solid fa-eraser"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @if (Auth::user()->hasRole('Super Admin'))
                                <tr class="align-middle text-center">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                            <a href="{{ route('users.show', ['id' => $user->id]) }}"
                                                class="btn btn-sm btn-info" title="Visualizar detalhes">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('users.edit', ['id' => $user->id]) }}"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <form id="formDelete{{ $user->id }}"
                                                action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                    data-delete-id="{{ $user->id }}" title="Apagar">
                                                    <i class="fa-solid fa-eraser"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endif
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
