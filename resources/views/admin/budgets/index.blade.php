@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Cotações</h4>
        <p>É possível emitir cotações aos clientes ou mesmo ter cotações para responder quando algum cliente solicita por
            meio do site da CO2 Peças. É necessário haver previamente criado o cliente no qual será respondida/criada a
            cotação.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('budgets.create') }}" class="btn btn-sm btn-primary">Gerar cotação</a>
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                Todas as cotações registradas
            @else
                Todas as suas cotações registradas
            @endif
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Cliente</th>
                    <th class="text-center">Vendedor(a)</th>
                    <th class="text-center">Criada em...</th>
                    <th class="text-center">QTD. Itens</th>
                    <th class="text-center">Total (R$)</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($budgets as $budget)
                    <tr class="align-middle text-center">
                        <td>
                            {{ str_pad($budget->id, 4, '0', STR_PAD_LEFT) }}
                        </td>
                        <td>
                            @if ($budget->status == 'VENDIDA')
                                <span class="text-success">{{ $budget->status }}</span>
                            @elseif ($budget->status == 'CONCLUÍDA')
                                <span class="text-primary">{{ $budget->status }}</span>
                            @elseif ($budget->status == 'EM ANDAMENTO')
                                <span class="text-secondary">{{ $budget->status }}</span>
                            @else
                                <span class="text-warning">{{ $budget->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($budget->customer_id)
                                {{ $budget->customer->user->name }}
                                @if ($budget->customer->type_buyer == 'PJ')
                                    <br>{{ $budget->customer->company }}
                                @endif
                            @else
                                <span class="text-danger">Não encontrado(a)!</span>
                            @endif
                        </td>
                        <td>
                            @if ($budget->user_id)
                                {{ $budget->user->name }}
                            @else
                                <span class="text-danger">Não encontrado(a)!</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($budget->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i') }}
                        </td>
                        <td>
                            {{ $budget->budgetItems->count() }}
                        </td>
                        <td>
                            R$ {{ number_format($budget->total_price, 2, ',', '.') }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show budget')
                                    <a href="{{ route('budgets.show', ['id' => $budget->id]) }}" class="btn btn-sm btn-info"
                                        title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @can('edit budget')
                                    <a href="{{ route('budgets.edit', ['id' => $budget->id]) }}" class="btn btn-sm btn-warning"
                                        title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endcan
                                @can('destroy budget')
                                    <form id="formDelete{{ $budget->id }}"
                                        action="{{ route('budgets.destroy', ['id' => $budget->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                            title="Apagar" data-delete-id="{{ $budget->id }}">
                                            <i class="fa-solid fa-eraser"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
