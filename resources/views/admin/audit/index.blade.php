@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Auditoria</h4>
        <p>
            Nesta parte do sistema é possível verificar o histórico das ações mais importantes executadas. É importante
            informar que para evitar sobrecarregar o banco de dados, ocorridos que passarem dos 30 dias de existência serão
            automaticamente apagados.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('audit.logs') }}" class="btn btn-sm btn-warning">Visualizar logs</a>
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Lista de ocorridos
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Área interagida</th>
                    <th class="text-center">Evento</th>
                    <th class="text-center">ID Executor(a)</th>
                    <th class="text-center">Momento do ocorrido</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($audits as $audit)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $audit->auditable_type }}
                        </td>
                        <td>
                            {{ $audit->event }}
                        </td>
                        <td>
                            @if ($audit->user_id)
                                {{ $audit->user_id }}
                            @else
                                <span class="text-center">NULL</span>
                            @endif
                        </td>
                        <td>
                            {{ $audit->created_at->format('d/m/Y H:i:s') }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                <a href="{{ route('audit.show', ['id' => $audit->id]) }}" class="btn btn-sm btn-info"
                                    title="Visualizar detalhes">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form id="formDelete{{ $audit->id }}"
                                    action="{{ route('audit.destroy', ['id' => $audit->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                        data-delete-id="{{ $audit->id }}" title="Apagar ocorrido">
                                        <i class="fa-solid fa-eraser"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
