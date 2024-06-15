@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Unidades da CO2</h4>
        <p>São através das unidades da CO2 Peças que algumas páginas são alimentadas com informações importantes sobre as
            localidades para um cliente chegar até uma loja autorizada da empresa ou se informar sobre onde está um
            produto dentre as possíveis opções. Por padrão sempre deve haver ao menos uma unidade cadastrada.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('edit headquarter')
            <a href="{{ route('headquarters.edit', ['id' => $headquarter->id]) }}" class="btn btn-sm btn-warning" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list headquarters')
            <a href="{{ route('headquarters.index') }}" class="btn btn-sm btn-secondary">Listar unidades</a>
        @endcan
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        Detalhes da unidade
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Visivel</h6>
                        <p class="card-text">{{ $headquarter->visible }}</p>
                        <h6 class="card-title fw-bold">Nome ou apelido</h6>
                        <p class="card-text">{{ $headquarter->name }}</p>
                        <h6 class="card-title fw-bold">CEP</h6>
                        <p class="card-text">{{ $headquarter->zip_code }}</p>
                        <h6 class="card-title fw-bold">Cidade</h6>
                        <p class="card-text">{{ $headquarter->city }} - {{ $headquarter->state }}</p>
                        <h6 class="card-title fw-bold">Bairro</h6>
                        <p class="card-text">{{ $headquarter->neighborhood }}</p>
                        <h6 class="card-title fw-bold">Rua/Avenida</h6>
                        <p class="card-text">{{ $headquarter->street }},<br>Nº {{ $headquarter->number }}</p>
                        <h6 class="card-title fw-bold">Complemento (se houver)</h6>
                        <p class="card-text">
                            @if ($headquarter->complement)
                                {{ $headquarter->complement }}
                            @else
                                -------------
                            @endif
                        </p>
                        <h6 class="card-title fw-bold">Localização e coordenadas
                            <br><small>({{ $headquarter->coordinates }})</small></h6>
                        <p class="card-text"><a class="btn btn-danger" title="Mostrar localização no Google Maps"
                                href="{{ $headquarter->map }}" target="_blank">
                                <i class="fa-solid fa-location-dot"></i> Google Maps
                            </a>
                        </p>
                        <h6 class="card-title fw-bold">Telefone</h6>
                        <p class="card-text">{{ $headquarter->telephone }}</p>
                        <h6 class="card-title fw-bold">Celular <i class="fa-brands fa-whatsapp text-success"></i></h6>
                        <p class="card-text">{{ $headquarter->whatsapp }}</p>
                        <h6 class="card-title fw-bold">Qtd. de produtos relacionados</h6>
                        <p class="card-text">{{ $totalProducts }}</p>
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($headquarter->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($headquarter->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <p class="card-text text-center">
                            <img src="{{ asset('img/headquarters/' . $headquarter->main_img) }}" class="rounded"
                                width="140" height="140" id="targetImg" alt="Imagem representativa">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
