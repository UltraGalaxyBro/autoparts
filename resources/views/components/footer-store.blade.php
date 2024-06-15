<footer class="py-3 my-4">
    <ul class="nav justify-content-center pt-2 pb-3 mb-3">
        <li class="nav-item"><a href="{{ route('policies') }}"
                title="Página informativa sobre as políticas e termos de uso"
                class="nav-link px-2 link-body-emphasis text-primary">Políticas e Termos de uso</a>
        </li>
        <li class="nav-item"><a href="{{ route('contacts') }}" title="Página informativa de contatos"
                class="nav-link px-2 link-body-emphasis text-primary">Contatos</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('about') }}" title="Página informativa sobre a CO2 Peças"
                class="nav-link px-2 link-body-emphasis text-primary">
                Sobre
                nós
            </a>
        </li>
    </ul>
    <div class="d-flex justify-content-center text-center flex-column flex-md-row align-items-center">
        <div class="col-md-5 mb-4">
            <img class="img-fluid" src="{{ asset('img/certificado-SSL.svg') }}" width="50%" alt="Logo">
        </div>
        <div class="col-md-5 mb-4">
            <img class="img-fluid" src="{{ asset('img/payment-methods.svg') }}" width="60%" alt="Logo">
        </div>
    </div>
    <p class="text-center text-body-secondary"><img src="{{ asset('img/logo.svg') }}" width="100" height="100"
            alt="Logo">
    </p>
    <p class="text-center text-body-secondary">CO2 PEÇAS, COMÉRCIO E DISTRIBUIÇÃO LTDA.</p>
    <p class="text-center text-body-secondary">CNPJ: 42.560.905/0001-66</p>
    <p id="direitos-autorais" class="text-center text-body-secondary"></p>
</footer>
