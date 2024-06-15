@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Auditoria</h4>
        <p>Nesta parte do sistema é possível verificar o histórico das ações mais importantes executadas. É importante
            informar que para evitar sobrecarregar o banco de dados, ocorridos que passarem dos 30 dias de existência serão
            automaticamente apagados.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('audit.index') }}" class="btn btn-sm btn-secondary">Listar ocorridos</a>
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Detalhes do ocorrido
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Área interagida</h6>
                        <p class="card-text">
                            {{ $audit->auditable_type }}
                        </p>
                        <h6 class="card-title fw-bold">Evento</h6>
                        <p class="card-text">
                            {{ $audit->event }}
                        </p>
                        <h6 class="card-title fw-bold">Executor(a)</h6>
                        <p class="card-text">
                            @if ($audit->user_id)
                                {{ $audit->user->name }}
                            @else
                                <span class="text-center">NULL</span>
                            @endif
                        </p>
                        <h6 class="card-title fw-bold">Área interagida</h6>
                        <p class="card-text">
                            {{ $audit->auditable_type }}
                        </p>
                        <h6 class="card-title fw-bold">ID do Item Interagido</h6>
                        <p class="card-text">{{ $audit->auditable_id }}</p>

                        <h6 class="card-title fw-bold">URL</h6>
                        <p class="card-text">{{ $audit->url }}</p>

                        <h6 class="card-title fw-bold">Endereço IP</h6>
                        <p class="card-text">{{ $audit->ip_address }}</p>

                        <h6 class="card-title fw-bold">Agente (Navegador/Dispositivo) do Usuário</h6>
                        <p class="card-text">{{ $audit->user_agent }}</p>

                        <h6 class="card-title fw-bold">Tags</h6>
                        <p class="card-text">
                            @if ($audit->tags)
                                {{ $audit->tags }}
                            @else
                                -----------
                            @endif
                        </p>

                        <h6 class="card-title fw-bold">Momento do ocorrido em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($audit->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>

                        <h6 class="card-title fw-bold">Valores Antigos</h6>
                        <ul class="card-text">
                            @if ($audit->old_values)
                                @foreach ($audit->old_values as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                @endforeach
                            @else
                                ------------
                            @endif
                        </ul>

                        <h6 class="card-title fw-bold">Novos Valores</h6>
                        <ul class="card-text">
                            @if ($audit->new_values)
                                @foreach ($audit->new_values as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                @endforeach
                            @else
                                ------------
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
