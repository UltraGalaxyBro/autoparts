@extends('layouts.admin')
@section('content')
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('users.self-edit', ['id' => auth()->user()->id]) }}" class="btn btn-sm btn-warning"
            title="Editar sua conta">
            <i class="fa-solid fa-pen"></i>
        </a>
    </div>
    <div class="mb-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        Sua conta
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold">Nome completo</h6>
                        <p class="card-text">{{ $user->name }}</p>
                        <h6 class="card-title fw-bold">E-mail</h6>
                        <p class="card-text">{{ $user->email }}</p>
                        <h6 class="card-title fw-bold">Função</h6>
                        <p class="card-text">{{ $user->getRoleNames()->first() }}</p>
                        @if ($user->headquarter_id)
                            <h6 class="card-title fw-bold">Trabalha na unidade...</h6>
                            <p class="card-text">{{ $user->headquarter->name }}, {{ $user->headquarter->city }}</p>
                        @endif
                        <br>
                        <h6 class="card-title fw-bold">Criado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($user->created_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                        <h6 class="card-title fw-bold">Atualizado em...</h6>
                        <p class="card-text">
                            {{ \Carbon\Carbon::parse($user->updated_at)->tz('America/Sao_Paulo')->format('d/m/y H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
