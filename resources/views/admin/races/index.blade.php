@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Corridas</h4>
        <p><small>Nesta área são registradas as corridas efetuadas pelos motoristas, sejam em entregas ou coletas. Sempre
                que
                chegar em um dos destinos, o motorista precisa sinalizar sua chegada. Ao concluir uma corrida, que se trata
                de
                sair de uma unidade da CO2 Peças e retornar para a mesma ao final, tal corrida é finalizada. Não é possível
                iniciar uma corrida caso haja outra EM ANDAMENTO.</small></p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list vehicles')
            <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-light">Veículos <i class="fa-solid fa-car"></i></a>
        @endcan
        @php
            $emAndamento = false;
        @endphp
        @if (count($races) > 0)
            @foreach ($races as $race)
                @if ($race->status == 'EM ANDAMENTO' && $race->user_id == auth()->user()->id)
                    @php
                        $emAndamento = true;
                    @endphp
                @endif
            @endforeach
        @endif
        @if (!$emAndamento)
            @can('begin race')
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalVehicleOptions">Registrar corrida</button>
            @endcan
        @else
            <button class="btn btn-sm btn-secondary" disabled>Indisponível registrar corrida</button>
        @endif
    </div>
    <div class="mb-1">
        <h5 class="text-center">
            @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                Todas as corridas registradas
            @else
                Todas as suas corridas registradas
            @endif
        </h5>
    </div>
    <div class="mb-5">
        <table class="table table-striped table-co2 dt-buttons" style="width:100%">
            <thead>
                <tr>
                    <th class="text-center">Momento da partida</th>
                    <th class="text-center">Momento da chegada</th>
                    <th class="text-center">Status</th>
                    <th class="text-center"><i class="fa-solid fa-file-pen"></i></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($races as $race)
                    <tr class="align-middle text-center">
                        <td>
                            @if ($race->created_at != null)
                                <i class="fa-solid fa-right-from-bracket"></i>
                                {{ \Carbon\Carbon::parse($race->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                            @else
                                Não registrado ainda
                            @endif
                        </td>
                        <td>
                            @if ($race->arrival_time != null)
                                <i class="fa-solid fa-right-to-bracket"></i>
                                {{ \Carbon\Carbon::parse($race->arrival_time)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                            @else
                                Não registrado ainda
                            @endif
                        </td>
                        <td>
                            @if ($race->status == 'EM ANDAMENTO')
                                <span class="text-warning">{{ $race->status }}</span>
                            @elseif ($race->status == 'CONCLUÍDA')
                                <span class="text-success">{{ $race->status }}</span>
                            @else
                                <span class="text-secondary">{{ $race->status }}</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Ações">
                                @can('show race')
                                    <a href="{{ route('races.show', ['id' => $race->id]) }}" class="btn btn-sm btn-info"
                                        title="Visualizar detalhes">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                @endcan

                                @if ($race->status == 'EM ANDAMENTO' && $race->user_id == auth()->user()->id)
                                    <a href="{{ route('races.race', ['id' => $race->id]) }}" class="btn btn-sm btn-warning"
                                        title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                @endif
                                @can('destroy race')
                                    <form id="formDelete{{ $race->id }}"
                                        action="{{ route('races.destroy', ['id' => $race->id]) }}" method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger btn-delete-in-group btnDelete"
                                            data-delete-id="{{ $race->id }}" title="Apagar">
                                            <i class="fa-solid fa-eraser"></i>
                                        </button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <x-modal-vehicle-options :$headquarters :$vehicles />
@endsection
