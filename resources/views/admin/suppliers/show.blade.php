@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Fornecedores</h4>
        <p>É importante registrar os fornecedores a título de organização na criação de um produto. Fornecedores estão
            vinculados a localização de um produto, visto que pode haver fornecedores em alguns locais, mas também não.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit supplier')
            <a href="{{ route('suppliers.edit', ['id' => $supplier->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list suppliers')
            <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-secondary">Listar fornecedores</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Detalhes do fornecedor
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome</h6>
                        <p class="card-text">{{ $supplier->name }}</p>
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($supplier->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($supplier->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if (count($supplier->supplierContacts) > 0)
            <h4 class="text-center">
                Informações de contato
            </h4>
            @foreach ($supplier->supplierContacts as $supplierContact)
                <ul class="list-group list-group-horizontal-xl mb-2">
                    <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Nome/Setor</div>
                            {{ $supplierContact->name }}
                        </div>
                    </li>
                    @if ($supplierContact->telephone)
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Telefone</div>
                                {{ $supplierContact->telephone }}
                                <a href="tel:+55{{ $supplierContact->telephone }}" target="_blank"
                                    class="btn btn-sm btn-light" title="Fazer ligação telefônica a este número">
                                    <i class="fa-solid fa-phone fa-xl"></i> <i class="fa-solid fa-share"></i>
                                </a>
                            </div>
                        </li>
                    @endif
                    @if ($supplierContact->celphone)
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Celular</div>
                                {{ $supplierContact->celphone }}
                                @if ($supplierContact->whatsapp === 1)
                                    @php
                                        $celphone = preg_replace('/\D/', '', $supplierContact->celphone);
                                    @endphp
                                    <a href="https://api.whatsapp.com/send?phone=55{{ $celphone }}" target="_blank"
                                        class="btn btn-sm btn-success" title="Chamar no WhatsApp">
                                        <i class="fa-brands fa-whatsapp fa-xl"></i> <i class="fa-solid fa-share"></i>
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endif
                    @if ($supplierContact->email)
                        <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">E-mail</div>
                                {{ $supplierContact->email }}
                                <a href="mailto:{{ $supplierContact->email }}" target="_blank"
                                    class="btn btn-sm btn-info" title="Enviar e-mail">
                                    <i class="fa-solid fa-envelope fa-xl"></i> <i class="fa-solid fa-share"></i>
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            @endforeach
        @endif
    </div>
@endsection
