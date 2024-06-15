@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Produtos</h4>
        <p>A parte mais essencial do sistema na CO2 Peças. Os produtos são dependentes, para cadastro, da existência das
            unidades da CO2, categorias, montadoras e marcas. É possível, naturalmente, que um produto esteja em locais
            diferentes, ou seja, possuir mais de uma localização.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit product')
            <a href="{{ route('products.edit', ['id' => $product->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list products')
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Listar produtos</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        Detalhes do produto
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-4 mb-2">
                                <div class="text-center">
                                    <div class="fw-bold mb-1">Imagem principal
                                        @if ($product->main_img == 'default-image.png' || $product->main_img == null)
                                            <br>(sem imagem no momento)
                                        @endif
                                    </div>
                                    <a href="{{ asset('img/products/' . $product->main_img) }}" target="_blank"
                                        title="Abrir a imagem em tamanho maior">
                                        <img src="{{ asset('img/products/' . $product->main_img) }}" class="rounded"
                                            width="140" height="140" id="targetImg" alt="Imagem representativa">
                                    </a>
                                </div>
                            </div>
                            @if ($product->extra_img !== null && $product->extra_img !== 'default-image.png')
                                <div class="col-md-4 mb-2">
                                    <div class="text-center">
                                        <div class="fw-bold mb-1">1ª imagem extra</div>
                                        <a href="{{ asset('img/products/extra/' . $product->extra_img) }}" target="_blank"
                                            title="Abrir a imagem em tamanho maior">
                                            <img src="{{ asset('img/products/extra/' . $product->extra_img) }}"
                                                class="rounded" width="140" height="140" id="targetImg1"
                                                alt="1ª imagem extra representativa">
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if ($product->extra_img2 !== null && $product->extra_img2 !== 'default-image.png')
                                <div class="col-md-4 mb-2">
                                    <div class="text-center">
                                        <div class="fw-bold mb-1">2ª imagem extra</div>
                                        <a href="{{ asset('img/products/extra/' . $product->extra_img2) }}" target="_blank"
                                            title="Abrir a imagem em tamanho maior">
                                            <img src="{{ asset('img/products/extra/' . $product->extra_img2) }}"
                                                class="rounded" width="140" height="140" id="targetImg2"
                                                alt="2ª imagem extra representativa">
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <ul class="list-group list-group-horizontal-md mb-2">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Registro criado em...</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ \Carbon\Carbon::parse($product->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-fill">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Atualizado em...</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ \Carbon\Carbon::parse($product->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}</span>
                                </div>
                            </li>
                        </ul>
                        <ol class="list-group mb-2">
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Nome</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Categoria</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->category->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Código interno</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->inside_code }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Montadora</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->automaker->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Marca</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->brand->name }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Código original</div>
                                    @if ($product->original_code)
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->original_code }}</span>
                                    @else
                                        -------------
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Código fabricante</div>
                                    @if ($product->brand_code)
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->brand_code }}</span>
                                    @else
                                        -------------
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Código(s) cruzado(s)</div>
                                    @if ($product->cross_code)
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->cross_code }}</span>
                                    @else
                                        -------------
                                    @endif
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Custo</div>
                                    <span class="badge text-bg-secondary p-2" style="font-size: 13px;">R$
                                        {{ number_format($product->cost, 2, ',', '.') }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                @php
                                    $cost = $product->cost;
                                    $price = $product->price;
                                    $msc = (($price - $cost) / $cost) * 100;
                                @endphp
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Margem sobre custo</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ number_format($msc, 2) }} %</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Preço</div>
                                    <span class="badge text-bg-secondary p-2" style="font-size: 13px;">R$
                                        {{ number_format($product->price, 2, ',', '.') }}</span>
                                </div>
                            </li>
                            @if ($product->ncm)
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">NCM</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->ncm }}</span>
                                    </div>
                                </li>
                            @endif
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                @php
                                    if ($product->total_quantity_sale == null) {
                                        $product->total_quantity_sale = 0;
                                    }
                                @endphp
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Quantidade vendida até então</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->total_quantity_sale }} und.</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Condição do produto</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->condition }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Visível em site</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->visible }}</span>
                                </div>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">Em promoção</div>
                                    <span class="badge text-bg-secondary p-2"
                                        style="font-size: 13px;">{{ $product->sale }}</span>
                                </div>
                            </li>
                            @if ($product->sale === 'Sim')
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    @php
                                        $sale_price = $product->sale_price;
                                        $discount = (($price - $sale_price) / $price) * 100;
                                    @endphp
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Desconto</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ number_format($discount, 2) }}
                                            %</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    @php
                                        $sale_price = $product->sale_price;
                                        $discount = (($price - $sale_price) / $price) * 100;
                                    @endphp
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Preço promocional</div>
                                        <span class="badge text-bg-secondary p-2" style="font-size: 13px;">R$
                                            {{ number_format($product->sale_price, 2, ',', '.') }}</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Promoção acaba em...</div>
                                        <span
                                            class="badge text-bg-secondary p-2">{{ \Carbon\Carbon::parse($product->sale_period_until)->tz('America/Sao_Paulo')->format('d/m/y') }}</span>
                                    </div>
                                </li>
                            @endif
                            @if ($product->visible === 'Sim')
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Aplicação</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->aplication }}</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Descrição em site</div>
                                        @if ($product->description !== null)
                                            <span class="badge text-bg-secondary p-2"
                                                style="font-size: 13px;">{{ $product->description }}</span>
                                        @else
                                            -------------
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Tipo de frete</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->freight }}</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Embalagem</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->packaging }}</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Altura</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->height }} cm</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Largura</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->width }} cm</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Comprimento</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->lenght }} cm</span>
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Peso</div>
                                        <span class="badge text-bg-secondary p-2"
                                            style="font-size: 13px;">{{ $product->weight }} kg</span>
                                    </div>
                                </li>
                            @endif
                        </ol>
                        @foreach ($product->productLocations as $index => $productLocation)
                            <ul class="list-group list-group-horizontal-xl mb-2">
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold"><i class="fa-solid fa-location-dot"></i></div>
                                        #{{ $index }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Fornecedor</div>
                                        {{ $productLocation->supplier->name }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Código fornecedor</div>
                                        @if ($productLocation->supplier_code)
                                            {{ $productLocation->supplier_code }}
                                        @else
                                            Não registrado
                                        @endif
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Localizado nesta unidade</div>
                                        {{ $productLocation->headquarter->name }},
                                        {{ $productLocation->headquarter->state }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Localização interna</div>
                                        {{ $productLocation->indoor_location }}
                                    </div>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-start flex-fill">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold">Quantidade</div>
                                        {{ $productLocation->quantity }} {{ $product->measure }}
                                    </div>
                                </li>
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @if (count($relatedProducts) === 0)
            <div class="row justify-content-center mt-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header text-center">
                            Produto(s) relacionado(s)
                        </div>
                        <div class="card-body text-center">
                            <p>Sem produtos relacionados registrados.</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row justify-content-center mt-3">
                <div class="col-md-8 table-responsive">
                    <table class="table table-striped" style="max-height: 300px; overflow-y: auto;">
                        <thead>
                            <tr>
                                <th colspan="3" class="text-center">Produto(s) relacionado(s)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($relatedProducts as $similarProduct)
                                <tr class="align-middle text-center">
                                    <td>
                                        <img src="{{ asset('img/products/' . $similarProduct->main_img) }}"
                                            class="rounded" width="75" height="75" id="targetImg"
                                            alt="Imagem representativa">
                                    </td>
                                    <td>
                                        @if ($similarProduct->original_code)
                                            {{ $similarProduct->original_code }}
                                        @endif
                                        @if ($similarProduct->brand_code)
                                            {{ $similarProduct->brand_code }}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('products.show', ['id' => $similarProduct->id]) }}"
                                            class="btn btn-sm btn-primary" title="Visualizar detalhes deste produto">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
