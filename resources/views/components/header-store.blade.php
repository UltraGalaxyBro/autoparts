@if (Route::currentRouteName() === 'cart' ||
        Route::currentRouteName() === 'checkout-delivery' ||
        Route::currentRouteName() === 'checkout-payment')
    <header class="fixed-top shadow">
        <nav class="navbar navbar-expand-lg p-2 navbar-co2">
            <div class="container-fluid">
                <a title="Voltar à página principal" class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo-and-name.svg') }}" alt="Logo e nome da empresa" width="138"
                        height="44">
                </a>
                @if (Route::currentRouteName() === 'cart')
                    <p class="text-light d-none d-lg-block">
                        <span class="fw-light">
                            <em>Cheque seu carrinho e vá para o checkout.</em>
                        </span>
                    </p>
                @else
                    <p class="text-light d-none d-lg-block">
                        <span class="fw-light">
                            <em>Cheque seu pedido e efetue a compra. <strong>O resto é conosco!</strong></em>
                        </span>
                    </p>
                @endif
                <p class="text-light mt-2" style="font-size: 11px;">
                    <i class="fa-brands fa-expeditedssl fa-lg"></i> <span class="fw-bold">Conexão
                        criptografada</span><br><i class="fa-solid fa-user-shield fa-lg"></i> <span
                        class="fw-bold">Compra segura</span>
                </p>
            </div>
        </nav>
    </header>
@else
    <header class="fixed-top shadow">
        <nav class="navbar navbar-expand-lg p-2 navbar-co2">
            <div class="container-fluid">
                <a title="Voltar à página principal" class="navbar-brand" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo-and-name.svg') }}" alt="Logo e nome da empresa" width="138"
                        height="44">
                </a>
                <button title="Botão aparente apenas em dispositivos móveis para retrair a barra de navegação."
                    class="navbar-toggler text-light" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <x-nav-store />
                </div>
                <form id="search" class="col-md-3 col-12 mx-auto mt-2" role="search"
                    action="{{ route('search-bar') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="input-group align-items-center">
                        @can('list cart')
                            <a title="Visualizar itens no carrinho" class="nav-link me-2" href="{{ route('cart') }}">
                                <i class="fa-solid fa-cart-shopping fa-xl text-light"></i>
                                <span class="badge rounded-pill bg-danger">
                                    @if (count(session('cart', [])) > 99)
                                        +99
                                    @else
                                        {{ count(session('cart', [])) }}
                                    @endif
                                </span>
                                <span class="visually-hidden">Quantidade de produtos</span>
                            </a>
                        @endcan
                        @guest
                            <a title="Visualizar itens no carrinho" class="nav-link me-2" href="#"
                                data-bs-toggle="modal" data-bs-target="#modalAccessClient">
                                <i class="fa-solid fa-cart-shopping fa-xl text-light"></i>
                            </a>
                        @endguest
                        <input type="text" name="value" id="value" class="form-control"
                            placeholder="Insira descrição ou código" aria-label="Search">
                        <button id="confirmSearch" title="Botão para confirmar busca inserida" type="submit"
                            class="btn btn-outline-light">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <ul id="suggestions" class="list-group mt-1">

                    </ul>
                </form>
            </div>
        </nav>
    </header>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#value').keyup(function() {
                    var query = $(this).val();
                    if (query.length >= 3) {
                        $.ajax({
                            url: "{{ route('suggested-products') }}",
                            method: 'POST',
                            data: {
                                query: query,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                var suggestions = $('#suggestions');
                                suggestions.empty();
                                var count =
                                    0;
                                $.each(data, function(index, product) {
                                    var suggestion = '';

                                    if (product.name && product.name.toLowerCase().indexOf(
                                            query.toLowerCase()) !== -1) {
                                        suggestion = product.name;
                                    } else if (product.inside_code && product.inside_code
                                        .toLowerCase().indexOf(query.toLowerCase()) !== -1
                                    ) {
                                        suggestion = product.inside_code;
                                    } else if (product.original_code && product
                                        .original_code.toLowerCase().indexOf(query
                                            .toLowerCase()) !== -1) {
                                        suggestion = product.original_code;
                                    } else if (product.brand_code && product.brand_code
                                        .toLowerCase().indexOf(query.toLowerCase()) !== -1
                                    ) {
                                        suggestion = product.brand_code;
                                    } else if (product.cross_code && product.cross_code
                                        .toLowerCase().indexOf(query.toLowerCase()) !== -1
                                    ) {
                                        suggestion = product.cross_code;
                                    }

                                    if (suggestion !== '' && count < 5) {
                                        suggestions.append(
                                            '<li class="list-group-item suggestion list-group-item-action cursor-pointer">' +
                                            suggestion + '</li>');
                                        count++;
                                    }
                                });

                                // Adiciona evento de clique às sugestões
                                $('.suggestion').click(function() {
                                    var selectedSuggestion = $(this).text();
                                    $('#value').val(
                                        selectedSuggestion);
                                    $('#confirmSearch').click();
                                });
                            }
                        });
                    } else {
                        $('#suggestions').html('');
                    }
                });
            });
        </script>
    @endpush
@endif
