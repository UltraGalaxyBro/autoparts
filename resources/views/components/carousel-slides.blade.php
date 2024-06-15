<section>
    <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#hero-carousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active c-item">
                <img src="{{ asset('img/carousel/carousel-img-00.svg') }}" class="d-block w-100 c-img" alt="Slide 1">
                <div class="carousel-caption top-0 mt-4">
                    <p class="mt-5 fs-3 fw-bold text-uppercase text-white text-shadow-main"><em>As Principais
                            Montadoras</em>
                    </p>
                    <h1 class="display-1 fw-bolder text-capitalize text-white text-shadow-main">Solução ao que você procura</h1>
                </div>
            </div>
            <div class="carousel-item c-item">
                <img src="{{ asset('img/carousel/carousel-img-01.svg') }}" class="d-block w-100 c-img" alt="Slide 2">
                <div class="carousel-caption top-0 mt-4">
                    <p class="text-uppercase fw-bold fs-3 mt-5 text-white text-shadow-main">
                        <em>Diversas
                            Marcas</em>
                    </p>
                    <p class="display-1 fw-bolder text-capitalize text-white text-shadow-main">
                        Muitas opções
                        pra
                        escolher
                    </p>
                </div>
            </div>
            <div class="carousel-item c-item">
                <img src="{{ asset('img/carousel/carousel-img-02.svg') }}" class="d-block w-100 c-img" alt="Slide 3">
                <div class="carousel-caption top-0 mt-4">
                    <p class="text-uppercase fw-bold fs-3 mt-5 text-white text-shadow-main"><em>Vendemos
                            Qualquer Peça Que
                            Precisar</em></p>
                    <p class="display-1 fw-bolder text-capitalize text-white text-shadow-main">Em Disposição
                        Todas As
                        Categorias</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#hero-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Retornar</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#hero-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Prosseguir</span>
        </button>
    </div>
</section>
