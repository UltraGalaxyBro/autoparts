<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <title>Acesso</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <!-- Sweet Alert -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
</head>

<body>
    <x-spinner />
    <x-alert />
    <div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row align-items-center g-lg-5 py-5">
            <div class="col-lg-7 text-center text-lg-start">
                <a title="Voltar à página principal" href="{{ route('welcome') }}">
                    <img src="{{ asset('img/logo.svg') }}" width="150" height="150"
                        alt="Logo para retorno À página principal">
                </a>
                <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3"><em>Área de acesso</em></h1>
                <p class="col-lg-10 fs-4">Fazer login ou criar uma conta<br>é <strong>rápido</strong> e
                    <strong>fácil</strong>.<br>Vá em frente! <i class="fa-solid fa-face-smile-wink fa-xl"></i>
                </p>

            </div>

            <div class="col-md-10 mx-auto col-lg-5">
                @yield('content')
            </div>

        </div>
    </div>
    <!--Page loader-->
    <script src="{{ asset('js/spinner.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <!--Bootstrap-->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!--Font Awesome-->
    <script src="{{ asset('js/all.min.js') }}"></script>
</body>

</html>
