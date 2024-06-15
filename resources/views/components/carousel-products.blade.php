<section class="my-5">
    <div class="container">
        <h2 class="pb-2 text-end border-bottom">
            <span class="badge text-bg-danger">
                Produtos que podem lhe
                interessar
            </span>
        </h2>
        @if ($products->isEmpty())
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <h5 class="text-center text-secondary">
                        Pedimos desculpas pois nosso estoque ainda está em processo de cadastro para ficar disponível...
                        Solicite uma cotação diretamente com nossos vendedores via WhatsApp para maior agilidade!
                    </h5>
                </div>
            </div>
        @else
            <div class="owl-carousel owl-theme text-center mt-5">
                @foreach ($products as $product)
                    <div class="d-inline-block mx-auto">
                        <x-product :$product />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

@push('scripts')
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                lazyLoad: true,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsiveClass: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1,
                        nav: false
                    },
                    600: {
                        items: 3,
                        nav: false
                    },
                    1000: {
                        items: 4,
                        nav: false,
                        loop: true
                    }
                }
            });
        });
    </script>
@endpush
