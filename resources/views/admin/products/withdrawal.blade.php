@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Retirada(s) solicitada(s) para tal produto</h4>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('products.withdrawal-records') }}" class="btn btn-sm btn-dark">Histórico de retiradas
            <i class="fa-solid fa-person-walking-luggage"></i>
        </a>
        @can('list products')
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Listar produtos</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Informações do produto
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <img src="{{ asset('img/products/' . $product->main_img) }}"
                                        alt="Imagem principal do produto" width="350" height="350"
                                        class="d-block img-fluid rounded">
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <span class="fw-bold">Descrição:</span>
                                            {{ $product->name }}
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">Marca:</span>
                                            {{ $product->brand->name }}
                                        </li>
                                        <li class="list-group-item">
                                            <span class="fw-bold">Códigos:</span>
                                            {{ $product->inside_code }} {{ $product->original_code }}
                                            {{ $product->brand_code }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h6 class="my-5 text-center">
            Requisições de retirada
        </h6>
        @php
            $user = Auth::user();
            $isSuperAdminOrAdmin = $user->hasAnyRole(['Super Admin', 'Admin']);
            $pendingWithdrawals = $product->productWithdrawals->filter(
                fn($withdrawal) => $withdrawal->withdrawal_status == 'PENDENTE' &&
                    ($isSuperAdminOrAdmin || $withdrawal->headquarter_id === $user->headquarter_id),
            );
        @endphp

        @if ($isSuperAdminOrAdmin || $pendingWithdrawals->count() > 0)
            <div class="table-responsive">
                <form action="{{ route('products.withdrawal-complete') }}" method="post">
                    @csrf
                    @method('post')

                    <table class="table table-sm table-bordered caption-top">
                        <caption>Selecione a retirada quando executada e salve</caption>
                        <thead class="table-info">
                            <tr class="align-middle text-center">
                                <th><i class="fa-solid fa-check-to-slot"></i></th>
                                <th>REQUERIDO POR...</th>
                                <th>LOCAÇÃO</th>
                                <th>QTD</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingWithdrawals as $item)
                                <tr class="align-middle text-center">
                                    <td>
                                        <input class="form-check-input border-primary" type="checkbox"
                                            value="{{ $item->id }}" name="selectedProductWithdrawalsIds[]">
                                    </td>
                                    <td class="fw-bold">{{ $item->required_by }}</td>
                                    <td class="fw-bold">
                                        <span style="font-size: 9px;">{{ $item->headquarter->name }},
                                            {{ $item->headquarter->city }}-{{ $item->headquarter->state }}</span><br>
                                        {{ $item->indoor_location }}
                                    </td>
                                    <td class="fw-bold">{{ $item->quantity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        @else
            <h6 class="text-center text-info">
                Todos os produtos já foram retirados ou você não trabalha na unidade em que o produto se
                encontra para efetuar a retirada.
            </h6>
        @endif
    </div>
@endsection
