@extends('layouts.store')

@section('content')
    <div class="divider-2">
    </div>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-5">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade carousel-dark">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        @if ($product->extra_img && $product->extra_img != 'default-image.png')
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        @endif
                        @if ($product->extra_img2 && $product->extra_img2 != 'default-image.png')
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        @endif
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="{{ asset('img/products/' . $product->main_img) }}" alt="Imagem principal do produto"
                                width="500" height="500" class="d-block img-fluid rounded">
                        </div>
                        @if ($product->extra_img && $product->extra_img != 'default-image.png')
                            <div class="carousel-item">
                                <img src="{{ asset('img/products/extra/' . $product->extra_img) }}"
                                    alt="1ª imagem extra do produto" width="500" height="500"
                                    class="d-block img-fluid rounded">
                            </div>
                        @endif
                        @if ($product->extra_img2 && $product->extra_img2 != 'default-image.png')
                            <div class="carousel-item">
                                <img src="{{ asset('img/products/extra/' . $product->extra_img2) }}"
                                    alt="2ª imagem extra do produto" width="500" height="500"
                                    class="d-block img-fluid rounded">
                            </div>
                        @endif
                    </div>
                    @if ($product->extra_img != 'default-image.png' || $product->extra_img2 != 'default-image.png')
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    @endif
                </div>
            </div>
            <div class="col-md-5">
                <div class="shadow rounded p-2">
                    <div class="text-end">
                        <a href="" target="_blank" title="Compartilhar este produto no WhatsApp"
                            class="btn btn-success rounded"><i class="fa-brands fa-whatsapp"></i> <i
                                class="fa-solid fa-share"></i></a>
                    </div>
                    <h3 class="text-center">
                        {{ $product->name }}
                    </h3>
                    <h4 class="text-center align-items-center">
                        <img src="{{ asset('img/logo.svg') }}" width="38" height="38" alt="Logo">
                        {{ $product->inside_code }}
                    </h4>

                    <div class="row mt-5">
                        <div class="col-md-6 text-center">
                            <span class="badge rounded-pill text-bg-primary">Montadora:</span><br>
                            <span class="fw-bold">{{ $product->automaker->name }}</span>
                        </div>
                        <div class="col-md-6 text-center">
                            <span class="badge rounded-pill text-bg-primary">Código original:</span><br>
                            <span class="fw-bold">
                                @if ($product->original_code)
                                    {{ $product->original_code }}
                                @else
                                    -----
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-md-6 text-center">
                            <span class="badge rounded-pill text-bg-primary">Marca:</span><br>
                            <span class="fw-bold">{{ $product->brand->name }}</span>
                        </div>
                        <div class="col-md-6 text-center">
                            <span class="badge rounded-pill text-bg-primary">Código fabricante:</span><br>
                            <span class="fw-bold">
                                @if ($product->brand_code)
                                    {{ $product->brand_code }}
                                @else
                                    -----
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center text-center ">
                        @if ($product->sale == 'Sim' && $product->sale_period_until > NOW())
                            <div class="col-md-4 rounded bg-secondary text-light">
                                <small><strong>Valor unitário normal</strong></small>
                                <h6 class="fw-light text-decoration-line-through" id="oldTotal">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </h6>
                            </div>
                            <div class="col-md-4">
                                <h4 class="fw-bold text-success" id="totalProduct">
                                    R$ {{ number_format($product->sale_price, 2, ',', '.') }}
                                </h4>
                            </div>
                            <input type="hidden" id="priceProduct" value="{{ $product->sale_price }}">
                        @else
                            <h4 class="fw-bold text-primary" id="totalProduct">
                                R$ {{ number_format($product->price, 2, ',', '.') }}
                            </h4>
                            <input type="hidden" id="priceProduct" value="{{ $product->price }}">
                        @endif
                    </div>
                    <div class="row my-3">
                        <div class="input-group d-flex justify-content-center">
                            <button type="button" id="decreaseBtn" class="btn btn-danger"><i
                                    class="fa-solid fa-minus"></i></button>
                            <input id="quantityShowed" style="width: 50px;" class="form-group text-center"
                                min="1" value="1">
                            <button type="button" id="increaseBtn" class="btn btn-success"><i
                                    class="fa-solid fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row pt-3 mb-4">
                        <div class="d-flex justify-content-center">
                            @can('store cart')
                                <form action="{{ route('cart-store-product') }}" method="POST">
                                    @csrf
                                    @method('post')
                                    <input type="hidden" id="quantity" name="quantity" value="1">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button title="Adicionar produto ao carrinho" type="submit"
                                        class="btn btn-lg btn-primary">
                                        Adicionar ao <i class="fa-solid fa-cart-shopping"></i>
                                    </button>
                                </form>
                            @endcan
                            @guest
                                <a href="#" class="btn btn-lg btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalAccessClient">Adicionar ao
                                    <i class="fa-solid fa-cart-shopping"></i></a>
                            @endguest
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--OUTRAS INFORMAÇÕES SOBRE-->
        <div class="accordion accordion-flush mt-5" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Aplicação resumida
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse show" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">{{ $product->aplication }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed  fw-bold" type="button" data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Informações adicionais do produto
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="badge rounded-pill text-bg-primary">Categoria do
                                    produto:</span><br>
                                <span class="fw-bold">{{ $product->category->name }}</span>
                            </li>
                            <li class="list-group-item"><span class="badge rounded-pill text-bg-primary">Condição do
                                    produto:</span><br>
                                <span class="fw-bold">{{ $product->condition }}</span>
                            </li>
                            @if ($product->ncm)
                                <li class="list-group-item"><span
                                        class="badge rounded-pill text-bg-primary">NCM:</span><br>
                                    <span class="fw-bold">{{ $product->ncm }}</span>
                                </li>
                            @endif
                            <li class="list-group-item"><span
                                    class="badge rounded-pill text-bg-primary">Medida:</span><br>
                                <span class="fw-bold">{{ $product->measure }}</span>
                            </li>
                            <li class="list-group-item"><span class="badge rounded-pill text-bg-primary">Peso
                                    (kg):</span><br>
                                <span class="fw-bold">{{ $product->weight }}</span>
                            </li>
                            <li class="list-group-item"><span class="badge rounded-pill text-bg-primary">Altura
                                    (cm):</span><br>
                                <span class="fw-bold">{{ $product->height }}</span>
                            </li>
                            <li class="list-group-item"><span class="badge rounded-pill text-bg-primary">Largura
                                    (cm):</span><br>
                                <span class="fw-bold">{{ $product->width }}</span>
                            </li>
                            <li class="list-group-item"><span class="badge rounded-pill text-bg-primary">Comprimento
                                    (cm):</span><br>
                                <span class="fw-bold">{{ $product->lenght }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if (count($relatedProducts) > 0)
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            Relacionado(s)
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <table class="table table-striped">
                                <tbody>
                                    @foreach ($relatedProducts as $similarProduct)
                                        <tr class="align-middle text-center">
                                            <td>
                                                <img src="{{ asset('img/products/' . $similarProduct->main_img) }}"
                                                    class="rounded" width="75" height="75" id="targetImg"
                                                    alt="Imagem representativa"><br>{{ $similarProduct->brand->name }}
                                            </td>
                                            <td>{{ $similarProduct->inside_code }}
                                                <br>
                                                {{ $similarProduct->original_code }}
                                                @if ($similarProduct->brand_code)
                                                    <br>{{ $similarProduct->brand_code }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('product', ['id' => $similarProduct->id]) }}"
                                                    class="btn btn-sm btn-primary"
                                                    title="Visualizar detalhes deste produto">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row justify-content-between mt-5">
            <div class="col-md-5 rounded bg-primary p-3 shadow mb-3">
                <h5 class="text-center text-light">
                    Disponibilidade do produto
                </h5>
                <table class="table">
                    <thead>
                        <tr class="align-middle text-center">
                            <th scope="col">Loja <i class="fa-solid fa-location-dot"></i></th>
                            <th scope="col">Estoque <i class="fa-solid fa-boxes-stacked"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($quantities as $quantity)
                            <tr class="align-middle text-center">
                                <td>
                                    {{ $quantity->headquarter->name }}<br>
                                    {{ $quantity->headquarter->city }}-{{ $quantity->headquarter->state }}
                                </td>
                                <td>
                                    @if ($quantity->total_quantity > 0)
                                        {{ $quantity->total_quantity }} {{ $product->measure }}
                                    @else
                                        SOB DEMANDA
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-5 rounded bg-light p-3 shadow text-dark mb-3">
                <p class="fw-bold">
                    <i class="fa-solid fa-triangle-exclamation text-warning fa-2xl"></i> Observação
                </p>
                <ul>
                    <li>Tenha certeza que está comprando o produto certo para a aplicação de seu(s) veículo(s). Caso esteja
                        com dúvidas não hesite em solicitar a opinião de nossos especialistas pelo botão do WhatsApp;</li>
                    <li>As imagens, em alguns casos, podem ser somente de caráter ilustrativo e não condizerem 100% com os
                        produtos;</li>
                    <li>As dimensões de medida descritas sobre o produto podem não estar precisas, ou seja, ser apenas
                        estimativa.</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="divider mt-5"></div>
    @guest
        <x-modal-access-client />
    @endguest
@endsection

@push('scripts')
    <script src="{{ asset('js/product.js') }}"></script>
@endpush
