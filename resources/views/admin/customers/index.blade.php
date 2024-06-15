@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Clientes</h4>
        <p>
            Todo cliente deve possuir um nível. Clientes podem ter conexões com orçamentos, carrinho de compras, vendas e
            seus endereços de entrega. Há a diferenciação de um cliente PF e PJ durante o registro.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">Registrar cliente</a>
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos os clientes registrados
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Comprador(a)</th>
                    <th class="text-center"><small>Nível de cliente</small></th>
                    <th class="text-center">Tipo de compra</th>
                    <th class="text-center"><small>Identificação</small></th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                    <tr class="align-middle text-center">
                        <td>
                            {{ $customer->user->name }}
                            @if ($customer->company)
                                <br>{{ $customer->company }}
                            @endif
                        </td>
                        <td>
                            {{ $customer->customerLevel->name }}
                        </td>
                        <td>
                            {{ $customer->type_buyer }}
                        </td>
                        <td>
                            @if ($customer->type_buyer == 'PF')
                                {{ $customer->cpf }}
                            @else
                                {{ $customer->cnpj }}
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show customer')
                                    <a href="{{ route('customers.show', ['id' => $customer->id]) }}" class="btn btn-sm btn-info"
                                        title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @can('edit customer')
                                    <a href="{{ route('customers.edit', ['id' => $customer->id]) }}"
                                        class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endcan
                                @can('destroy customer')
                                    <form id="formDelete{{ $customer->id }}"
                                        action="{{ route('customers.destroy', ['id' => $customer->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                            data-delete-id="{{ $customer->id }}" title="Apagar">
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
