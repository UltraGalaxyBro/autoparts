@extends('layouts.admin')
@section('content')
    @if (auth()->check())
        @php
            $fullName = auth()->user()->name;
            $firstName = explode(' ', $fullName)[0];
        @endphp
        <h1>Olá, {{ $firstName }}!</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="container">
                    <div class="p-3 text-center bg-body-tertiary rounded-3">
                        <img src="{{ asset('img/logo.svg') }}" alt="Logo" width="100" height="100">
                        <h3 class="text-body-emphasis mt-3">Bem-vindo(a) à CO2 Peças!</h3>
                        <p class="col-lg-8 mx-auto fs-5 text-muted">
                            Lembre-se, cada um de vocês desempenha um papel vital em nossa jornada rumo ao sucesso. Juntos,
                            podemos alcançar grandes feitos e enfrentar qualquer desafio que surja em nosso caminho.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-10">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <h5 class="fw-bold text-center mb-3">
                            Frase inspiradora do momento <i class="fa-solid fa-face-laugh-wink fa-xl"></i>
                        </h5>
                        <figure class="text-center">
                            <blockquote class="blockquote">
                                <p><i class="fa-solid fa-quote-left"></i> {{ $quote['frase'] }}. <i
                                        class="fa-solid fa-quote-right"></i></p>
                            </blockquote>
                            <figcaption class="blockquote-footer">
                                <cite title="Source Title">{{ $quote['autor'] }}</cite>
                            </figcaption>
                        </figure>
                    </div>
                </div>

            </div>
        </div>
    @endif
@endsection
