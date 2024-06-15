@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Unidades da CO2</h4>
        <p>São através das unidades da CO2 Peças que algumas páginas são alimentadas com informações importantes sobre as
            localidades para um cliente chegar até uma loja autorizada da empresa ou se informar sobre onde está um
            produto dentre as possíveis opções. Só será possível apagar uma unidade da CO2 Peças caso não haja a localização
            de nenhum produto relacionado com a mesma e se ela não for a única registrada.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('create headquarter')
            <a href="{{ route('headquarters.create') }}" class="btn btn-sm btn-primary">Criar unidade</a>
        @endcan
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            Todos as unidades CO2 Peças cadastradas
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center"><i class="fa-solid fa-image"></i></th>
                    <th class="text-center">Nome</th>
                    <th class="text-center"><small>Localidade</small></th>
                    <th class="text-center"><small>Contatos</small></th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($headquarters as $headquarter)
                    <tr class="align-middle text-center">
                        <td>
                            <img class="rounded" src="{{ asset('img/headquarters/' . $headquarter->main_img) }}"
                                width="66px" height="50px" alt="Imagem sobre a fachada">
                        </td>
                        <td>
                            {{ $headquarter->name }}
                        </td>
                        <td>
                            {{ $headquarter->city }}-{{ $headquarter->state }} | {{ $headquarter->neighborhood }}
                        </td>
                        <td>
                            <i class="fa-solid fa-phone-volume"></i> {{ $headquarter->telephone }} | <i
                                class="fa-brands fa-whatsapp text-success"></i> {{ $headquarter->whatsapp }}
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show headquarter')
                                    <a href="{{ route('headquarters.show', ['id' => $headquarter->id]) }}"
                                        class="btn btn-sm btn-info" title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan
                                @can('edit headquarter')
                                    <a href="{{ route('headquarters.edit', ['id' => $headquarter->id]) }}"
                                        class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endcan

                                @if ($totalData > 1 && $headquarter->productLocations->count() == 0)
                                    @can('destroy headquarter')
                                        <form id="formDelete{{ $headquarter->id }}"
                                            action="{{ route('headquarters.destroy', ['id' => $headquarter->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                                data-delete-id="{{ $headquarter->id }}" title="Apagar">
                                                <i class="fa-solid fa-eraser"></i>
                                            </button>
                                        </form>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
