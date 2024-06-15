<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">

<head>
    @if (view()->exists('components.themes'))
        <script src="{{ asset('js/themes.js') }}"></script>
    @endif
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    @if (Route::currentRouteName() === 'product')
        <title>{{ $product->name }}</title>
        <meta property="og:title" content="{{ $product->name }}">
        @if ($product->description)
            <meta property="og:description" content="{{ $product->description }}">
            <meta name="description" content="{{ $product->description }}">
        @else
            <meta property="og:description" content="{{ $product->aplication }}">
            <meta name="description" content="{{ $product->aplication }}">
        @endif
        <meta property="og:url" content="{{ url('/product/' . $product->id) }}">
        <meta name="keywords" content="{{ $product->keywords }}">
        <meta property="og:keywords" content="{{ $product->keywords }}" />
        <meta property="og:type" content="website">
        <meta property="og:image" content="{{ $product->main_img }}">
        <meta property="og:image:secure_url" content="{{ asset('img/products/' . $product->main_img) }}" />
        <meta name="author" content="CO2 Peças, Pablo Nogueira de Faria">
        <link rel="image_src" href="{{ asset('img/products/' . $product->main_img) }}" />
    @else
        <title>CO2 Peças</title>
        <meta name="description"
            content="Descubra a excelência em peças de linha pesada na nossa loja especializada. Encontre uma vasta seleção de componentes de alta qualidade para veículos comerciais e industriais. Combinamos expertise e variedade para atender às suas necessidades, oferecendo soluções duráveis e confiáveis. Explore nosso catálogo abrangente e garanta o desempenho ideal para sua frota. Seja para caminhões, ônibus ou maquinário pesado, nossa loja é o destino definitivo para quem busca peças que fazem a diferença. Qualidade superior e atendimento excepcional - sua jornada rumo à eficiência com seu veículo pesado começa aqui.">
        <meta name="keywords"
            content="peças de caminhão, caminhão, autopeças, reposição, manutenção, mecânica, motor, freios, suspensão, transmissão, embreagem, direção, elétrica, pneus, acessórios, segurança, Mercedes-Benz, Volkswagen, Scania, Volvo, Iveco, Ford, Chevrolet, Actros, Axor, Constellation, P-Series, FH, Daily, F-Series, filtro de óleo, bomba de água, junta de cabeçote, biela, pistão, eixo, rolamento, mola, cabo de embreagem, mangueira de radiador, pneu para caminhão, acessorios para caminhão, equipamentos de segurança para caminhão">
        <meta name="author" content="CO2 Peças, Pablo Nogueira de Faria">
    @endif
    <!-- Estilos do index -->
    <link rel="stylesheet" href="{{ asset('css/store.css') }}">
    @if (view()->exists('components.themes'))
        <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
    @endif
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!-- Owl Carousel -->
    @if (view()->exists('components.carousel-products'))
        <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    @endif
    @if (view()->exists('components.alert'))
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @endif
    @if (Route::currentRouteName() === 'contacts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
</head>

<body>
    <x-spinner />
    <x-alert />
    <x-themes />
    <x-whatsapp />
    <x-header-store />

    <main>
        @yield('content')
    </main>

    <x-footer-store />
    <script src="{{ asset('js/spinner.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/all.min.js') }}"></script>

    @stack('scripts')

    @if (view()->exists('components.footer-store'))
        <script type="text/javascript">
            var direitosAutorais = document.getElementById('direitos-autorais');
            var anoAtual = new Date().getFullYear();
            direitosAutorais.innerHTML = '&copy; ' + anoAtual + '. Todos os direitos reservados';
        </script>
    @endif

    @include('cookie-consent::index')
</body>

</html>
