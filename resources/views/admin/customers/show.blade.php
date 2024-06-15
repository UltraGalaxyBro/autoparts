@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Clientes</h4>
        <p>
            Todo cliente deve possuir um nível. Só é possível criar um cliente manualmente se já houver o mesmo cadastrado
            como usuário antes e tendo a função de 'Cliente' estabelecida na criação. Clientes podem ter conexões com
            orçamentos,
            carrinho de compras, vendas e
            seus endereços de entrega. Há a diferenciação de um cliente PF e PJ durante o registro.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit customer')
            <a href="{{ route('customers.edit', ['id' => $customer->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list customers')
            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary">Listar clientes</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        Detalhes da unidade
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome</h6>
                        <p class="card-text">{{ $customer->user->name }}</p>
                        <h6 class="card-title fw-bold">E-mail</h6>
                        <p class="card-text">{{ $customer->user->email }}</p>
                        <h6 class="card-title fw-bold">Telefone</h6>
                        <p class="card-text">
                            @if ($customer->telephone)
                                {{ $customer->telephone }}
                            @else
                                Não registrado
                            @endif
                        </p>
                        <h6 class="card-title fw-bold">Celular
                            @if ($customer->whatsapp == 'Sim')
                                <i class="fa-brands fa-whatsapp text-success"></i>
                            @endif
                        </h6>
                        <p class="card-text">{{ $customer->celphone }}</p>
                        @if ($customer->type_buyer == 'PF')
                            <h6 class="card-title fw-bold">Tipo de compra que realiza</h6>
                            <p class="card-text">Pessoa Física</p>
                            <h6 class="card-title fw-bold">CPF</h6>
                            <p class="card-text">{{ $customer->cpf }}</p>
                        @else
                            <h6 class="card-title fw-bold">Tipo de compra que realiza</h6>
                            <p class="card-text">Pessoa Jurídica</p>
                            <h6 class="card-title fw-bold">Nome fantasia</h6>
                            <p class="card-text">{{ $customer->company }}</p>
                            <h6 class="card-title fw-bold">CNPJ</h6>
                            <p class="card-text">{{ $customer->cnpj }}</p>
                            <h6 class="card-title fw-bold">Inscrição Estadual</h6>
                            <p class="card-text">{{ $customer->ie }}</p>
                        @endif
                        @php
                            if ($customer->purchases == null) {
                                $customer->purchases = 0;
                            }
                        @endphp
                        <h6 class="card-title fw-bold">Compras realizadas</h6>
                        <p class="card-text">R$ {{ number_format($customer->purchases, 2, ',', '.') }}</p>
                        <h6 class="card-title fw-bold">Última compra realizada em...</h6>
                        <p class="card-text">
                            @if ($customer->last_purchase_at == null)
                                <small>Nenhum registro de data da última compra encontrado.</small>
                            @else
                                {{ \Carbon\Carbon::parse($customer->last_purchase_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                            @endif
                        </p>
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($customer->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($customer->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
