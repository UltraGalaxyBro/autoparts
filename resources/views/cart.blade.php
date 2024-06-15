@extends('layouts.store')

@section('content')
    <div class="divider-2"></div>
    <div class="container pb-5">
        @if (!empty($cart))
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="row">
                                    <div class="col-lg-7">
                                        <h5 class="mb-3">
                                            <a href="{{ route('products') }}" title="Ver mais produtos" class="text-body">
                                                <i class="fas fa-long-arrow-alt-left me-2"></i>Ver mais produtos
                                            </a>
                                        </h5>
                                        <hr>
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <p class="mb-1">
                                                    <i class="fa-solid fa-cart-shopping fa-2xl"></i>
                                                    Carrinho de compras
                                                </p>
                                            </div>
                                        </div>
                                        @foreach ($cart as $productId => $item)
                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="row text-center align-items-center">
                                                        <div class="col-md-2">
                                                            <img src="{{ asset('img/products/' . $item['image']) }}"
                                                                class="img-fluid rounded-3" alt="Imagem do produto">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <h5>
                                                                <a class="text-decoration-none"
                                                                    href="{{ route('product', ['id' => $item['id']]) }}">
                                                                    {{ $item['name'] }}
                                                                </a>
                                                            </h5>
                                                            <p class="small mb-0">{{ $item['brand'] }}</p>
                                                            <p class="small mb-0">{{ $item['codes'] }}</p>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <div class="input-group d-flex justify-content-center">
                                                                <button type="button" title="Diminuir quantidade"
                                                                    class="btn btn-secondary btn-decrease"
                                                                    data-product-id="{{ $item['id'] }}">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </button>
                                                                <input type="number" placeholder="QTD."
                                                                    id="quantity-{{ $item['id'] }}" name="quantity"
                                                                    style="width: 45px;"
                                                                    class="form-group text-center quantity-input"
                                                                    data-product-id="{{ $item['id'] }}" min="1"
                                                                    value="{{ $item['quantity'] }}">
                                                                <button type="button" title="Aumentar quantidade"
                                                                    class="btn btn-primary btn-increase"
                                                                    data-product-id="{{ $item['id'] }}">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </button>
                                                            </div>
                                                            <div>
                                                                <p class="d-none" data-price="{{ $item['price'] }}">Preço
                                                                    unitário: R$
                                                                    {{ number_format($item['price'], 2, ',', '.') }}</p>
                                                                <h5 class="m-3" id="subtotal-{{ $item['id'] }}">
                                                                    R$
                                                                    {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                                                                </h5>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <form id="formDelete{{ $item['id'] }}"
                                                                action="{{ route('cart-destroy-product', ['id' => $item['id']]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                                    data-delete-id="{{ $item['id'] }}"
                                                                    title="Remover produto do carrinho">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-lg-5">
                                        <div class="card text-white rounded-3" style="background-color: #114C8D;">
                                            <div class="card-body">
                                                <div class="">
                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <h5 class="mb-0">Resumo do carrinho</h5>
                                                        <i class="fa-regular fa-chart-bar fa-2xl"></i>
                                                    </div>

                                                </div>

                                                <hr class="my-4">

                                                <p class="mb-3">
                                                    Você possui
                                                    @if (count(session('cart', [])) != 1)
                                                        <strong>{{ count(session('cart', [])) }}</strong> itens
                                                    @else
                                                        <strong>{{ count(session('cart', [])) }}</strong> item
                                                    @endif
                                                    no carrinho
                                                </p>

                                                <div class="d-flex justify-content-between mb-5">
                                                    <p class="mb-2">Subtotal produto(s)</p>
                                                    <h3 class="mb-2 fw-bold" id="total-products">R$ 0,00</h3>
                                                </div>

                                                <a href="#" title="Fechar pedido e realizar checkout" data-mdb-button-init data-mdb-ripple-init
                                                    class="btn btn-success btn-block btn-lg">
                                                    <div class="d-flex justify-content-between">
                                                        <span>Checkout<i
                                                                class="fas fa-long-arrow-alt-right ms-2"></i></span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </section>
        @else
            <div class="text-center pt-5 mt-5">
                <h6 class="fw-bold mb-5">O carrinho está vazio...<br>Adicione produto(s) ao carrinho para efetuar uma
                    compra!
                </h6>
                <img src="{{ asset('img/empty-cart.svg') }}" alt="Imagem do carrinho vazio" class="img-fluid"
                    width="350" height="350">
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('products') }}" class="btn btn-primary btn-lg">Ver produtos</a>
            </div>
        @endif
    </div>
    <div class="divider mt-5"></div>
    <div id="route-update" data-route="{{ route('cart-update-product') }}"></div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.btnDelete').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                var deleteId = this.getAttribute('data-delete-id');
                Swal.fire({
                    title: "Você tem certeza?",
                    text: "Você está prestes a remover este produto do carrinho.",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#bc0f0f",
                    cancelButtonColor: "#808080",
                    confirmButtonText: "Sim, remover!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`formDelete${deleteId}`).submit();
                    }
                });
            })
        })

        $(document).ready(function() {
            $(".quantity-input").change(function() {
                var productId = $(this).data("product-id");
                var newQuantity = parseInt($(this).val());

                if (newQuantity > 0) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('cart-update-product') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            productId: productId,
                            newQuantity: newQuantity
                        },
                        success: function(response) {
                            console.log(response);
                            updateSubtotal(productId, newQuantity);
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    console.log("Quantidade inválida");
                }
            });

            $(".btn-decrease, .btn-increase").click(function() {
                var productId = $(this).data("product-id");
                var quantityInput = $("#quantity-" + productId);
                var newQuantity = parseInt(quantityInput.val());

                if ($(this).hasClass("btn-decrease")) {
                    if (newQuantity > 1) {
                        newQuantity = newQuantity - 1;
                    }
                } else {
                    newQuantity = newQuantity + 1;
                }

                quantityInput.val(newQuantity).change();
            });

            function updateSubtotal(productId, newQuantity) {
                var price = parseFloat($("#subtotal-" + productId).siblings("[data-price]").data("price"));
                var subtotal = price * newQuantity;
                var subtotalFormatted = subtotal.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2
                });
                $("#subtotal-" + productId).text("R$ " + subtotalFormatted);

                var total = 0;
                $(".quantity-input").each(function() {
                    var productId = $(this).data("product-id");
                    var quantity = parseInt($(this).val());
                    var price = parseFloat($("#subtotal-" + productId).siblings("[data-price]").data(
                        "price"));
                    total += price * quantity;
                });

                var totalFormatted = total.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2
                });

                $("#total-products").text("R$ " + totalFormatted);
            }

            updateSubtotal();

        });
    </script>
@endpush
