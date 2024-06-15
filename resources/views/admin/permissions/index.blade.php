@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Permissões</h4>
        <p>Com as permissões é possível delimitar o acesso do usuário de acordo com a função vinculada ao mesmo.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list roles')
            <a href="{{ route('roles.index') }}" class="btn btn-sm btn-secondary">Listar funções</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Permissões da função <strong>{{ $role->name }}</strong>
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Descrição</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    @if ($permission->id > 12)
                        <tr class="align-middle text-center">
                            <td>
                                {{ $permission->title }}
                            </td>
                            <td>
                                @if (in_array($permission->id, $rolePermissions ?? []))
                                    <span class="badge text-bg-success">Autorizado</span>
                                @else
                                    <span class="badge text-bg-danger">Bloqueado</span>
                                @endif
                            </td>
                            <td>
                                @can('update permission')
                                    <form action="{{ route('permissions.update', ['id' => $permission->id]) }}" method="POST">
                                        @csrf
                                        @method('put')

                                        <input type="hidden" value="{{ $role->id }}" name="role_id">

                                        @if (in_array($permission->id, $rolePermissions ?? []))
                                            <button type="submit" class="btn btn-sm btn-danger" title="Bloquear acesso"><i
                                                    class="fa-solid fa-lock"></i></button>
                                        @else
                                            <button type="submit" class="btn btn-sm btn-success" title="Autorizar acesso"><i
                                                    class="fa-solid fa-lock-open"></i></button>
                                        @endif
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
