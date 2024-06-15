@extends('layouts.store')
@section('content')
    <div class="container">
        <div class="row">
            <div id="container-filters" class="col-md-3">
                <div class="row justify-content-center">
                    <div class="col-md-6 mb-1 text-center">
                        @if ($products)
                            @if (
                                (request()->has('category_id') && request()->has('automaker_id') && request()->has('brand_id')) ||
                                    count($products) < 2)
                                <button title="Apresentar os filtros" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#filterArea" aria-controls="filterArea"
                                    class="btn btn-lg btn-secondary disabled rounded-pill fw-bold">
                                    Filtros
                                    <i class="fa-solid fa-filter"></i>
                                </button>
                            @else
                                <button title="Apresentar os filtros" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#filterArea" aria-controls="filterArea"
                                    class="btn btn-lg btn-danger rounded-pill fw-bold">
                                    Filtros
                                    <i class="fa-solid fa-filter"></i> <i class="fa-solid fa-arrow-pointer"></i>
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
                @if (request()->has('search') ||
                        request()->has('category_id') ||
                        request()->has('automaker_id') ||
                        request()->has('brand_id'))
                    <h5 class="mt-3 text-center text-secondary">
                        Resultado com o(s) termo(s):<br>
                    </h5>

                    <div class="selected-filters text-center">
                        @if (request()->has('search'))
                            <span class="m-1 badge bg-danger">{{ request()->input('search') }} <a
                                    href="{{ remove_query_parameter('search') }}" title="Remover filtro"
                                    class="text-reset"><i class="fa-solid fa-circle-minus fa-xl"></i></a>
                            </span>
                        @endif

                        @if (request()->has('category_id'))
                            <span class="m-1 badge bg-danger">categoria:
                                {{ App\Models\Category::find(request()->input('category_id'))->name }} <a
                                    href="{{ remove_query_parameter('category_id') }}" title="Remover filtro"
                                    class="text-reset"><i class="fa-solid fa-circle-minus fa-xl"></i></a>
                            </span>
                        @endif

                        @if (request()->has('automaker_id'))
                            <span class="m-1 badge bg-danger">montadora:
                                {{ App\Models\Automaker::find(request()->input('automaker_id'))->name }} <a
                                    href="{{ remove_query_parameter('automaker_id') }}" title="Remover filtro"
                                    class="text-reset"><i class="fa-solid fa-circle-minus fa-xl"></i></a>
                            </span>
                        @endif

                        @if (request()->has('brand_id'))
                            <span class="m-1 badge bg-danger">marca:
                                {{ App\Models\Brand::find(request()->input('brand_id'))->name }} <a
                                    href="{{ remove_query_parameter('brand_id') }}" title="Remover filtro"
                                    class="text-reset"><i class="fa-solid fa-circle-minus fa-xl"></i></a>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
            <div class="offcanvas offcanvas-start" tabindex="-1" id="filterArea" aria-labelledby="filterAreaLabel">
                <div class="offcanvas-header">
                    <h3 class="offcanvas-title" id="filterAreaLabel">Filtros <i class="fa-solid fa-filter"></i></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    @if (count($categories) > 0)
                        <div class="mb-5">
                            <h5 class="text-start"><u>Categorias</u></h5>
                            @foreach ($categories as $category)
                                <a class="text-decoration-none"
                                    href="{{ route('products', array_merge(request()->query(), ['category_id' => $category->id, 'page' => null])) }}"
                                    title="Opção de filtragem sobre categoria">
                                    <span class="badge bg-primary">{{ $category->name }}
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if (count($automakers) > 0)
                        <div class="mb-5">
                            <h5 class="text-start"><u>Montadoras</u></h5>
                            @foreach ($automakers as $automaker)
                                <a class="text-decoration-none"
                                    href="{{ route('products', array_merge(request()->query(), ['automaker_id' => $automaker->id, 'page' => null])) }}"
                                    title="Opção de filtragem sobre montadora">
                                    <span class="badge bg-primary">{{ $automaker->name }}
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                    @if (count($brands) > 0)
                        <div class="mb-5">
                            <h5 class="text-start"><u>Marcas</u></h5>
                            @foreach ($brands as $brand)
                                <a class="text-decoration-none"
                                    href="{{ route('products', array_merge(request()->query(), ['brand_id' => $brand->id, 'page' => null])) }}"
                                    title="Opção de filtragem sobre marca">
                                    <span class="badge bg-primary">{{ $brand->name }}
                                        <i class="fa-solid fa-circle-plus"></i>
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            <div id="container-products" class="col-md-9">
                <div class="row justify-content-center">
                    <div class="col-9">
                        <hr class="border border-danger border-3 opacity-100">
                    </div>
                </div>
                <div>
                    @if ($products)
                        @if (count($products) > 0)
                            <div class="grid">
                                @foreach ($products as $product)
                                    <x-product :$product />
                                @endforeach
                            </div>
                        @else
                            <h3 class="text-center text-secondary">Nenhum produto encontrado.</h3>
                            <h6 class="text-center text-secondary">Consulte a <em>CO2 Peças</em> via botão WhatsApp.</h6>
                            <div class="text-center">
                                <img class="img-fluid" src="{{ asset('img/icon-empty-search.png') }}"
                                    alt="ícone simbolizando que a busca não encontrou produtos">
                            </div>
                        @endif
                    @endif
                </div>
                <div class="row justify-content-center mx-5 my-5">
                    <div class="col">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="divider"></div>
    @guest
        <x-modal-access-client />
    @endguest
@endsection
