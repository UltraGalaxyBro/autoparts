<ul class="navbar-nav mx-auto mb-2 mb-lg-0 text-small">
    <li class="nav-item">
        <a title="Navegar pela seção dos produtos" class="nav-link text-light" href="{{ route('products') }}">
            <i class="fa-solid fa-gears fa-2xl"></i>
            Produtos
        </a>
    </li>
    @if (auth()->check())
        @if (auth()->user()->hasRole('Cliente'))
            <li class="nav-item dropdown">
                <a title="Opções do usuário em sua conta" href="#" class="nav-link dropdown-toggle text-light"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user fa-2xl"></i>
                </a>
                <ul class="dropdown-menu text-center">
                    {{-- OPÇÕES DO ÍCONE EXCLUSIVO DE ACESSO COM SESSÃO DE CLIENTES - INÍCIO --}}
                    <li>
                        <a title="Visualizar os dados do usuário" class="dropdown-item" href="#"><i
                                class="fa-solid fa-address-card fa-xl"></i> Meus
                            dados
                        </a>
                    </li>
                    <li>
                        <a title="Visualizar os pedidos do usuário" class="dropdown-item" href="#">
                            <i class="fa-solid fa-bag-shopping fa-xl"></i> Meus
                            pedidos
                        </a>
                    </li>
                    {{-- OPÇÕES DO ÍCONE EXCLUSIVO DE ACESSO COM SESSÃO DE CLIENTES - INÍCIO --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a title="Sair da conta" class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="fa-solid fa-person-walking-arrow-loop-left fa-xl"></i> Sair
                        </a>
                    </li>
                </ul>
            </li>
        @else
            <li class="nav-item dropdown">
                <a title="Opções do usuário em sua conta" href="#" class="nav-link dropdown-toggle text-light"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user-secret fa-2xl"></i>
                </a>
                <ul class="dropdown-menu text-center">
                    {{-- OPÇÕES DO ÍCONE EXCLUSIVO DE ACESSO COM SESSÃO DE MEMBROS DA EMPRESA - INÍCIO --}}
                    <li>
                        <a title="Visualizar os dados do usuário" class="dropdown-item"
                            href="{{ route('admin.home') }}"><i class="fa-solid fa-dungeon fa-xl"></i> Sistema
                        </a>
                    </li>
                    {{-- OPÇÕES DO ÍCONE EXCLUSIVO DE ACESSO COM SESSÃO DE MEMBROS DA EMPRESA - FIM --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a title="Sair da conta" class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="fa-solid fa-person-walking-arrow-loop-left fa-xl"></i> Sair
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    @else
        {{-- ÍCONE DE ACESSO SEM HAVER SESSÃO --}}
        <li class="nav-item">
            <a title="Realizar login ou criar conta" href="{{ route('auth.login') }}" class="nav-link text-light">
                <i class="fa-solid fa-door-open fa-2xl"></i> Acesso
            </a>
        </li>
    @endif
</ul>
