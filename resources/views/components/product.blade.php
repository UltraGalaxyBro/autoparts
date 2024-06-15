@if ($product->sale == 'Sim' && $product->sale_period_until > NOW())
    <div class="card" style="width: 15rem; position: relative;">
        <div class="p-3">
            <img src="{{ asset('img/products/' . $product->main_img) }}" class="card-img-top rounded"
                alt="Imagem do produto">
        </div>
        <div class="row">
            <div class="card-title text-center">
                <span class="badge text-bg-secondary mt-3 text-decoration-line-through" style="font-size: 13px;">R$
                    {{ number_format($product->price, 2, ',', '.') }}</span>
                <span class="badge text-bg-danger mt-3 fw-bolder" style="font-size: 15px;">R$
                    {{ number_format($product->sale_price, 2, ',', '.') }} <i class="fa-solid fa-fire fa-lg"></i></span>
            </div>
        </div>
        <h6 class="card-title mx-2" title="{{ $product->name }}"
            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $product->name }}
        </h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item text-light"
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background-color: #083e78;">
                MARCA:<br><strong><em>{{ $product->brand->name }}</em></strong></li>

            @php
                $codes = '';
                if ($product->original_code != null) {
                    $codes .= $product->original_code . ' ';
                }
                if ($product->brand_code != null) {
                    $codes .= $product->brand_code . ' ';
                }

                $codes .= $product->inside_code;
            @endphp

            <li class="list-group-item text-light" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $codes }}"
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background-color: #c40212;">
                CÓDIGO(S):<br><strong>{{ $codes }}</strong></li>
        </ul>
        <div class="d-flex justify-content-between position-absolute bottom-50 start-50 translate-middle-x">
            <a title="Visualizar detalhes do produto" href="{{ route('product', ['id' => $product->id]) }}"
                class="btn btn-primary shadow" style="margin-right: 10px;">
                <i class="fa-solid fa-eye fa-xl"></i>
            </a>
            @can('store cart')
                <form action="{{ route('cart-store-product') }}" method="POST" style="margin-left: 10px;">
                    @csrf
                    @method('post')
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="quantity" name="quantity" value="1">
                    <button title="Adicionar produto ao carrinho" type="submit" class="btn btn-primary shadow">
                        <i class="fa-solid fa-cart-plus fa-xl"></i>
                    </button>
                </form>
            @endcan
            @guest
                <a title="Adicionar produto ao carrinho" data-bs-toggle="modal" data-bs-target="#modalAccessClient"
                    href="#" class="btn btn-primary shadow" style="margin-left: 10px;">
                    <i class="fa-solid fa-cart-plus fa-xl"></i>
                </a>
            @endguest
        </div>
    </div>
@else
    <div class="card" style="width: 15rem; position: relative;">
        <div class="p-3">
            <img src="{{ asset('img/products/' . $product->main_img) }}" class="card-img-top rounded"
                alt="Imagem do produto">
        </div>
        <div class="card-title text-center">
            <span class="badge text-bg-success mt-3 p-2 fw-bolder" style="font-size: 15px;">R$
                {{ number_format($product->price, 2, ',', '.') }}</span>
        </div>
        <h6 class="card-title mx-2" title="{{ $product->name }}"
            style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
            {{ $product->name }}
        </h6>
        <ul class="list-group list-group-flush">
            <li class="list-group-item  text-light"
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background-color: #083e78;">
                MARCA:<br><strong><em>{{ $product->brand->name }}</em></strong></li>

            @php
                $codes = '';
                if ($product->original_code != null) {
                    $codes .= $product->original_code . ' ';
                }
                if ($product->brand_code != null) {
                    $codes .= $product->brand_code . ' ';
                }

                $codes .= $product->inside_code;
            @endphp
            <li class="list-group-item text-light" data-bs-toggle="tooltip" data-bs-placement="top"
                title="{{ $codes }}"
                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; background-color: #c40212;">
                CÓDIGO(S):<br><strong>{{ $codes }}</strong>
            </li>
        </ul>
        <div class="d-flex justify-content-between position-absolute bottom-50 start-50 translate-middle-x">
            <a title="Visualizar detalhes do produto" href="{{ route('product', ['id' => $product->id]) }}"
                class="btn btn-primary shadow" style="margin-right: 10px;">
                <i class="fa-solid fa-eye fa-xl"></i>
            </a>
            @can('store cart')
                <form action="{{ route('cart-store-product') }}" method="POST" style="margin-left: 10px;">
                    @csrf
                    @method('post')
                    <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="quantity" name="quantity" value="1">
                    <button title="Adicionar produto ao carrinho" type="submit" class="btn btn-primary shadow">
                        <i class="fa-solid fa-cart-plus fa-xl"></i>
                    </button>
                </form>
            @endcan
            @guest
                <a title="Adicionar produto ao carrinho" data-bs-toggle="modal" data-bs-target="#modalAccessClient"
                    href="#" class="btn btn-primary shadow" style="margin-left: 10px;">
                    <i class="fa-solid fa-cart-plus fa-xl"></i>
                </a>
            @endguest
        </div>
    </div>
@endif
