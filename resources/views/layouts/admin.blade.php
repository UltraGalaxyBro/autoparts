@php
    //MANIPULANDO A EXIBIÇÃO NA BARRA LATERAL DO LAYOUT DE ACORDO COM A PÁGINA PRESENTE
    $layoutAboutCustomers = [
        'levels.index',
        'levels.create',
        'levels.show',
        'levels.edit',
        'addresses.index',
        'addresses.create',
        'addresses.show',
        'addresses.edit',
    ];
    $layoutAboutProducts = [
        'suppliers.index',
        'suppliers.create',
        'suppliers.show',
        'suppliers.edit',
        'categories.index',
        'automakers.index',
        'brands.index',
        'categories.create',
        'automakers.create',
        'brands.create',
        'categories.show',
        'automakers.show',
        'brands.show',
        'categories.edit',
        'automakers.edit',
        'brands.edit',
    ];
    $presentIconPagesDashboard = ['dashboards.index'];
    //sobre usuários
    $presentIconPagesUser = ['users.index', 'users.create', 'users.show', 'users.edit'];
    $presentIconLabel = ['labeling.create'];
    $presentIconPagesRoleAndPermission = ['roles.index', 'roles.create', 'roles.edit', 'permissions.index'];
    //sobre clientes
    $presentIconPagesCustomer = ['customers.index', 'customers.create', 'customers.show', 'customers.edit'];
    $presentIconPagesLevel = ['levels.index', 'levels.create', 'levels.show', 'levels.edit'];
    $presentIconPagesAddress = ['addresses.index', 'addresses.create', 'addresses.show', 'addresses.edit'];
    //sobre produtos
    $presentIconPagesProduct = [
        'products.index',
        'products.create',
        'products.show',
        'products.edit',
        'products.withdrawal-records',
        'products.withdrawal',
    ];
    $presentIconPagesCategory = ['categories.index', 'categories.create', 'categories.show', 'categories.edit'];
    $presentIconPagesAutomaker = ['automakers.index', 'automakers.create', 'automakers.show', 'automakers.edit'];
    $presentIconPagesBrand = ['brands.index', 'brands.create', 'brands.show', 'brands.edit'];
    $presentIconPagesHeadquarter = [
        'headquarters.index',
        'headquarters.create',
        'headquarters.show',
        'headquarters.edit',
    ];
    $presentIconPagesSupplier = ['suppliers.index', 'suppliers.create', 'suppliers.show', 'suppliers.edit'];
    //sobre orçamento
    $presentIconPagesBackup = ['backups.index'];
    //sobre auditoria
    $presentIconPagesAudit = ['audit.index'];
    //sobre backups
    $presentIconPagesBudget = ['budgets.index', 'budgets.create', 'budgets.clone', 'budgets.show', 'budgets.edit'];
    //sobre corrida
    $presentIconPagesRace = [
        'races.index',
        'races.create',
        'races.show',
        'races.edit',
        'vehicles.index',
        'vehicles.create',
        'vehicles.show',
        'vehicles.edit',
    ];
    //sobre auditorias e logs
    $presentIconAuditLogs = ['audit.index', 'audit.show', 'audit.logs'];
    //INSERINDO QUALQUER ROTA QUE NECESSITE DOS SCRIPTS E ESTILOS DO DATATABLES
    $routesWithDataTables = [
        'customers.index',
        'levels.index',
        'addresses.index',
        'categories.index',
        'automakers.index',
        'brands.index',
        'suppliers.index',
        'headquarters.index',
        'users.index',
        'roles.index',
        'permissions.index',
        'races.index',
        'budgets.index',
        'vehicles.index',
        'backups.index',
        'audit.index',
        'products.withdrawal-records',
    ];
    //INSERINDO QUALQUER ROTA QUE NECESSITE DOS SCRIPTS ESPECÍFICOS
    $scriptsForUsers = ['users.edit', 'users.self-edit'];
    $scriptsForLevels = ['levels.create', 'levels.edit'];
    $scriptsForCustomers = ['customers.create', 'customers.edit'];
    $scriptsForCategories = ['categories.create', 'categories.edit'];
    $scriptsForAutomakers = ['automakers.create', 'automakers.edit'];
    $scriptsForHeadquarters = ['headquarters.create', 'headquarters.edit'];
    $scriptsForProducts = ['products.create', 'products.edit'];
    $scriptsForBudgets = ['budgets.create', 'budgets.clone', 'budgets.edit'];
    $scriptsForRaces = ['races.race'];
    $scriptsForLabeling = ['labeling.create'];
    $scriptsForSuppliers = ['suppliers.create', 'suppliers.edit'];
    $scriptsAndStlyeForRacesMaps = ['races.show'];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="auto">

<head>
    @if (view()->exists('components.themes'))
        <script src="{{ asset('js/themes.js') }}"></script>
    @endif
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    <title>Sistema CO2 Peças</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (view()->exists('components.themes'))
        <link rel="stylesheet" href="{{ asset('css/themes.css') }}">
    @endif
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    @if (in_array(Route::currentRouteName(), $routesWithDataTables))
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
    @endif
    @if (Route::currentRouteName() === 'products.index')
        <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/responsive.bootstrap5.min.css') }}">
    @endif
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <!--Área administrativa-->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap-5-theme.min.css') }}" />
    @if (in_array(Route::currentRouteName(), $scriptsForProducts) ||
            in_array(Route::currentRouteName(), $scriptsForBudgets) ||
            in_array(Route::currentRouteName(), $scriptsForLabeling) ||
            in_array(Route::currentRouteName(), $scriptsForSuppliers))
        <script defer src="{{ asset('js/alpine-mask.js') }}"></script>
        <script defer src="{{ asset('js/alpine.js') }}"></script>
    @endif
    <!-- Sweet Alert -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    @if (in_array(Route::currentRouteName(), $scriptsAndStlyeForRacesMaps))
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
            integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @endif
    <style>
        /*SOMENTE NA SESSÃO DE COTAÇÕES --- INÍCIO */
        .total-cost-budget {
            z-index: 1500;
            margin-bottom: 28.4em;
            opacity: 0.4;
        }

        .total-price-budget {
            z-index: 1500;
            margin-bottom: 19em;
            opacity: 0.4;
        }

        /*SOMENTE NA SESSÃO DE COTAÇÕES --- INÍCIO */
    </style>
</head>

<body>
    <x-spinner />
    <x-themes />
    <x-alert />
    <div class="wrapper">
        <aside id="sidebar" class="js-sidebar">
            <!-- Content For Sidebar -->
            <div class="h-100">
                <div class="sidebar-logo">
                    <a href="{{ route('admin.home') }}" title="Voltar à página inicial">
                        <img src="{{ asset('img/logo-and-name.svg') }}" alt="Logo e nome da empresa" width="138"
                            height="44">
                    </a>
                </div>
                <ul class="sidebar-nav mb-5">
                    <li class="sidebar-header text-light">
                        Funcionalidades
                    </li>
                    @can('list dashboards')
                        @php
                            $styleOptionDashboard = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesDashboard)) {
                                $styleOptionDashboard = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('dashboards.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionDashboard }} link-danger">
                                <i class="fa-solid fa-chart-simple pe-2 fa-xl"></i>
                                Gráficos
                            </a>
                        </li>
                    @endcan
                    @can('list products')
                        @php
                            $styleOptionProduct = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesProduct)) {
                                $styleOptionProduct = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('products.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionProduct }} link-danger"><i
                                    class="fa-solid fa-boxes-stacked pe-2 fa-xl"></i> Produtos</a>
                        </li>
                    @endcan
                    @can('create labeling')
                        @php
                            $styleOptionLabel = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconLabel)) {
                                $styleOptionLabel = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('labeling.create') }}"
                                class="sidebar-link fw-bold {{ $styleOptionLabel }} link-danger">
                                <i class="fa-solid fa-tags pe-2 fa-xl"></i> Etiquetagem
                            </a>
                        </li>
                    @endcan
                    @can('list budgets')
                        @php
                            $styleOptionBudget = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesBudget)) {
                                $styleOptionBudget = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('budgets.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionBudget }} link-danger">
                                <i class="fa-solid fa-list-ol pe-2 fa-xl"></i>
                                Cotações
                            </a>
                        </li>
                    @endcan
                    @can('list roles')
                        @php
                            $styleOptionRoleAndPermission = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesRoleAndPermission)) {
                                $styleOptionRoleAndPermission = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('roles.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionRoleAndPermission }} link-danger"><i
                                    class="fa-solid fa-network-wired pe-2 fa-xl"></i> Funções
                            </a>
                        </li>
                    @endcan
                    @can('list users')
                        @php
                            $styleOptionUser = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesUser)) {
                                $styleOptionUser = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('users.index') }}"
                                class="sidebar-link fw-bold collapsed {{ $styleOptionUser }} link-danger"><i
                                    class="fa-solid fa-users pe-2 fa-xl"></i> Usuários
                            </a>
                        </li>
                    @endcan
                    @can('list customers')
                        @php
                            $styleOptionCustomer = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesCustomer)) {
                                $styleOptionCustomer = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('customers.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionCustomer }} link-danger"><i
                                    class="fa-solid fa-user-tag pe-2 fa-xl"></i> Clientes
                            </a>
                        </li>
                    @endcan
                    @can('list headquarters')
                        @php
                            $styleOptionHeadquarter = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesHeadquarter)) {
                                $styleOptionHeadquarter = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('headquarters.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionHeadquarter }} link-danger"><i
                                    class="fa-solid fa-location-dot pe-2 fa-xl"></i> Unidades da CO2</a>
                        </li>
                    @endcan
                    @can('list races')
                        @php
                            $styleOptionRace = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesRace)) {
                                $styleOptionRace = 'text-danger';
                            }
                        @endphp
                        <!--<li class="sidebar-item">
                                        <a href="{{ route('races.index') }}"
                                            class="sidebar-link fw-bold {{ $styleOptionRace }} link-danger"><i
                                            class="fa-solid fa-truck-fast pe-2 fa-xl"></i> Corridas
                                        </a>
                                    </li>-->
                    @endcan
                    @canany(['list levels', 'list addresses', 'list suppliers', 'list headquarters', 'list categories',
                        'list brands', 'list automakers'])
                        @php
                            $styleComplementarData = 'text-light';
                            $dropdownComplementarData = '';

                            if (
                                in_array(Route::currentRouteName(), $layoutAboutCustomers) ||
                                in_array(Route::currentRouteName(), $layoutAboutProducts)
                            ) {
                                $styleComplementarData = 'text-danger';
                                $dropdownComplementarData = 'show';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="#"
                                class="sidebar-link fw-bold collapsed {{ $styleComplementarData }} link-danger"
                                data-bs-target="#multi" data-bs-toggle="collapse" aria-expanded="false"><i
                                    class="fa-solid fa-table pe-2 fa-xl"></i>
                                <small>Dados complementares</small>
                            </a>
                            <ul id="multi"
                                class="sidebar-dropdown list-unstyled {{ $dropdownComplementarData }} collapse"
                                data-bs-parent="#sidebar">

                                @canany(['list levels', 'list addresses'])
                                    @php
                                        $styleOptionSideBarAboutCustomer = 'text-light';
                                        $styleOptionLevel = 'text-light';
                                        $styleOptionAddress = 'text-light';

                                        if (in_array(Route::currentRouteName(), $presentIconPagesLevel)) {
                                            $styleOptionSideBarAboutCustomer = 'text-danger';
                                            $styleOptionLevel = 'text-danger';
                                        }

                                        if (in_array(Route::currentRouteName(), $presentIconPagesAddress)) {
                                            $styleOptionSideBarAboutCustomer = 'text-danger';
                                            $styleOptionAddress = 'text-danger';
                                        }

                                    @endphp
                                    <li class="sidebar-item">
                                        <a href="#"
                                            class="sidebar-link fw-bold collapsed {{ $styleOptionSideBarAboutCustomer }} link-danger"
                                            data-bs-target="#level-5" data-bs-toggle="collapse" aria-expanded="false">Sobre
                                            clientes</a>
                                        <ul id="level-5"
                                            class="sidebar-dropdown list-unstyled collapse
                                        @if (in_array(Route::currentRouteName(), $layoutAboutCustomers)) show @endif">
                                            @can('list levels')
                                                <li class="sidebar-item">
                                                    <a href="{{ route('levels.index') }}"
                                                        class="sidebar-link fw-bold {{ $styleOptionLevel }} link-danger"><i
                                                            class="fa-solid fa-bars-staggered pe-2"></i> Níveis para clientes</a>
                                                </li>
                                            @endcan
                                            @can('list addresses')
                                                <li class="sidebar-item">
                                                    <a href="#{{-- route('addresses.index') --}}"
                                                        class="sidebar-link fw-bold {{ $styleOptionAddress }} link-danger"><i
                                                            class="fa-solid fa-map-location-dot pe-2"></i> Endereços dos
                                                        clientes</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany
                                @canany(['list suppliers', 'list categories', 'list brands', 'list automakers'])
                                    @php
                                        $styleOptionSideBarAboutProduct = 'text-light';
                                        $styleOptionSupplier = 'text-light';
                                        $styleOptionCategory = 'text-light';
                                        $styleOptionAutomaker = 'text-light';
                                        $styleOptionBrand = 'text-light';
                                        $styleOptionHeadquarter = 'text-light';

                                        if (in_array(Route::currentRouteName(), $presentIconPagesSupplier)) {
                                            $styleOptionSideBarAboutProduct = 'text-danger';
                                            $styleOptionSupplier = 'text-danger';
                                        }

                                        if (in_array(Route::currentRouteName(), $presentIconPagesCategory)) {
                                            $styleOptionSideBarAboutProduct = 'text-danger';
                                            $styleOptionCategory = 'text-danger';
                                        }

                                        if (in_array(Route::currentRouteName(), $presentIconPagesAutomaker)) {
                                            $styleOptionSideBarAboutProduct = 'text-danger';
                                            $styleOptionAutomaker = 'text-danger';
                                        }

                                        if (in_array(Route::currentRouteName(), $presentIconPagesBrand)) {
                                            $styleOptionSideBarAboutProduct = 'text-danger';
                                            $styleOptionBrand = 'text-danger';
                                        }

                                    @endphp
                                    <li class="sidebar-item">
                                        <a href="#"
                                            class="sidebar-link fw-bold collapsed {{ $styleOptionSideBarAboutProduct }} link-danger"
                                            data-bs-target="#level-2" data-bs-toggle="collapse" aria-expanded="false">Sobre
                                            produtos</a>
                                        <ul id="level-2"
                                            class="sidebar-dropdown list-unstyled collapse
                                            @if (in_array(Route::currentRouteName(), $layoutAboutProducts)) show @endif">
                                            @can('list suppliers')
                                                <li class="sidebar-item">
                                                    <a href="{{ route('suppliers.index') }}"
                                                        class="sidebar-link fw-bold {{ $styleOptionSupplier }} link-danger"><i
                                                            class="fa-solid fa-people-carry-box pe-2"></i> Fornecedores</a>
                                                </li>
                                            @endcan
                                            @can('list categories')
                                                <li class="sidebar-item">
                                                    <a href="{{ route('categories.index') }}"
                                                        class="sidebar-link fw-bold {{ $styleOptionCategory }} link-danger"><i
                                                            class="fa-solid fa-layer-group pe-2"></i> Categorias</a>
                                                </li>
                                            @endcan
                                            @can('list automakers')
                                                <li class="sidebar-item">
                                                    <a href="{{ route('automakers.index') }}"
                                                        class="sidebar-link fw-bold {{ $styleOptionAutomaker }} link-danger"><i
                                                            class="fa-solid fa-industry pe-2"></i>
                                                        Montadoras</a>
                                                </li>
                                            @endcan
                                            @can('list brands')
                                                <li class="sidebar-item">
                                                    <a href="{{ route('brands.index') }}"
                                                        class="sidebar-link fw-bold {{ $styleOptionBrand }} link-danger"><i
                                                            class="fa-solid fa-copyright pe-2"></i>
                                                        Marcas</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                @endcanany
                            </ul>
                        </li>
                    @endcanany
                    <li class="sidebar-item">
                        <a href="{{ route('welcome') }}" class="sidebar-link fw-bold text-light link-danger">
                            <i class="fa-solid fa-store pe-2 fa-xl"></i> Voltar à loja
                        </a>
                    </li>
                    @php
                        $styleOptionAuditLogs = 'text-light';
                        if (in_array(Route::currentRouteName(), $presentIconAuditLogs)) {
                            $styleOptionAuditLogs = 'text-danger';
                        }
                    @endphp
                    @hasanyrole('Super Admin|Admin')
                        <li class="sidebar-item">
                            <a href="{{ route('audit.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionAuditLogs }} link-danger">
                                <i class="fa-solid fa-binoculars pe-2 fa-xl"></i> Auditoria e Logs
                            </a>
                        </li>
                    @endhasanyrole
                    @can('list backups')
                        @php
                            $styleOptionBackup = 'text-light';
                            if (in_array(Route::currentRouteName(), $presentIconPagesBackup)) {
                                $styleOptionBackup = 'text-danger';
                            }
                        @endphp
                        <li class="sidebar-item">
                            <a href="{{ route('backups.index') }}"
                                class="sidebar-link fw-bold {{ $styleOptionBackup }} link-danger">
                                <i class="fa-solid fa-database pe-2 fa-xl"></i> Backups
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </aside>
        <div class="main">
            <nav class="navbar navbar-expand px-3 border-bottom">
                <button class="btn" id="sidebar-toggle" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                <i class="fa-solid fa-user-gear fa-xl"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('users.self-show', ['id' => auth()->user()->id]) }}"
                                    class="dropdown-item">Sua conta</a>
                                <a href="{{ route('auth.logout') }}" class="dropdown-item">Sair</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mt-1" style="font-size: 10px;">
                                Desenvolvido por <em>Pablo Nogueira</em>.
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline me-5">
                                <li class="list-inline-item">
                                    <a href="#">Ajuda</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!--Page loader-->
    <script src="{{ asset('js/spinner.js') }}"></script>
    <!--Jquery-->
    <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
    <!--Select2-->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!--Bootstrap-->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <!--Script personalizado do mapa das corridas-->
    @if (in_array(Route::currentRouteName(), $scriptsAndStlyeForRacesMaps))
        <script type="text/javascript">
            const markers = @json($markers);

            const key = 'aW7yVY7E4a8mNEBCskUT';
            const map = L.map('map').setView([-16.686898, -49.264792], 13); // Coordenadas de Goiânia

            L.tileLayer(`https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=${key}`, { //style URL
                tileSize: 512,
                zoomOffset: -1,
                minZoom: 1,
                attribution: '\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e',
                crossOrigin: true
            }).addTo(map);

            //const markers = [{
            //    coordinates: [-16.68, -49.31],
            //    popupText: 'CO2 Peças',
            //    isCO2: true // indicador para identificar a CO2 Peças
            //}];

            markers.forEach(marker => {
                let markerOptions = {}; // opções padrão para o marcador

                // Verifique se o marcador é da CO2 Peças
                if (marker.isCO2) {
                    markerOptions.icon = L.icon({
                        iconUrl: '/img/marker-map-co2.png',
                        iconSize: [41, 41],
                        iconAnchor: [22, 94],
                        popupAnchor: [-3, -87]
                    });
                }

                const newMarker = L.marker(marker.coordinates, markerOptions).addTo(map);
                newMarker.bindPopup(marker.popupText);
            });
        </script>
        {{-- <script src="{{ asset('js/admin.race-maps.js') }}"></script> --}}
    @endif
    <!--Font Awesome-->
    <script src="{{ asset('js/all.min.js') }}"></script>
    <!--Área administrativa-->
    <script src="{{ asset('js/admin.js') }}"></script>
    @if (in_array(Route::currentRouteName(), $routesWithDataTables))
        <!-- DataTables - INÍCIO -->
        <script src="{{ asset('js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('js/custom.datatables.js') }}"></script>
        <!-- DataTables - FIM -->
    @endif
    @if (Route::currentRouteName() === 'products.index')
        <script src="{{ asset('js/datatables.min.js') }}"></script>
        <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    @endif
    <!-- Scripts específicos - INÍCIO -->
    @if (in_array(Route::currentRouteName(), $scriptsForUsers))
        <script src="{{ asset('js/admin.users.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForLevels))
        <script src="{{ asset('js/admin.levels.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForCustomers))
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/admin.customers.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForCategories))
        <script src="{{ asset('js/admin.categories.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForAutomakers))
        <script src="{{ asset('js/admin.automakers.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForHeadquarters))
        <script src="{{ asset('js/admin.headquarters.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForProducts))
        <script defer src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/admin.products.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForBudgets))
        <script src="{{ asset('js/admin.budgets.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForLabeling))
        <script defer src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/admin.labeling.js') }}"></script>
    @endif
    @if (in_array(Route::currentRouteName(), $scriptsForRaces))
        <script src="{{ asset('js/admin.races.js') }}"></script>
    @endif

    @stack('scripts')

</body>

</html>
