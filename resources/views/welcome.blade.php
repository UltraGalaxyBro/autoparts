@extends('layouts.store')

@section('content')
    <div class="divider-2"></div>

    <x-carousel-slides />

    <div class="divider"></div>

    <x-carousel-products :$products />
    <x-banner-budget />
    <!--LISTANDO AS QUALIDADES ATRAVÉS DE UM FEATURE-->
    <section class="container mt-3">
        <h2 class="pb-2 border-bottom"><span class="badge text-bg-danger">Várias vantagens para você</span>
        </h2>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 py-5">
            <div class="col d-flex align-items-start">
                <i class="fa-solid fa-truck-fast fa-2xl"></i>
                <div class="ms-3">
                    <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Frete do seu jeito</h3>
                    <p>Não importando qual transportadora você prefira, iremos enviar seus produtos como desejar
                        após a compra.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <i class="fa-solid fa-headset fa-2xl"></i>
                <div class="ms-3">
                    <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Atendimento Excepcional ao Cliente</h3>
                    <p>Nossa equipe está pronta para fornecer suporte e orientação, assegurando que você tenha a
                        melhor experiência ao escolher suas peças conosco.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <i class="fa-solid fa-building-user fa-2xl"></i>
                <div class="ms-3">
                    <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Benefícios adicionais para CNPJ</h3>
                    <p>Para clientes com CNPJ oferecemos facilidade no processo de faturamento para a empresa,
                        descontos exclusivos em compras de grande volume e auxílio em demandas corporativas.</p>
                </div>
            </div>
            <div class="col d-flex align-items-start">
                <i class="fa-solid fa-award fa-2xl"></i>
                <div class="ms-3">
                    <h3 class="fw-bold mb-0 fs-4 text-body-emphasis">Garantia de Qualidade</h3>
                    <p>Nossas peças, novas e seminovas, são submetidas a padrões de qualidade, além de possuir
                        garantia. Queremos que você compre solução ao adquirir nossos produtos!</p>
                </div>
            </div>
        </div>
    </section>

    <div class="divider"></div>

    @guest
        <x-modal-access-client />
    @endguest
@endsection
