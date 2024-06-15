@extends('layouts.auth')

@section('content')
    <form action="{{ route('auth.process') }}" method="POST" id="loginForm"
        class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
        @csrf
        @method('post')

        <h4 class="fw-bold text-center">Fazer login</h4>
        <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com"
                value="{{ old('email') }}">
            <label for="email">E-mail</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Senha escolhida"
                value="{{ old('password') }}">
            <label for="password">Senha</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary mb-2" type="submit"
            onclick="this.innerText = 'Entrando...'">Entrar</button>
        <hr class="my-4">
        <p>Esqueceu a senha? <a href="{{ route('auth.recovery') }}" title="Recuperar senha"
                class="text-decoration-none badge text-bg-info fs-6">Redefinir <i class="fa-solid fa-arrow-pointer"></i></a>
        </p>
        <p>Não possui conta? <a href="{{ route('auth.create') }}" title="Criar conta"
                class="text-decoration-none badge text-bg-warning fs-6">
                Criar <i class="fa-solid fa-arrow-pointer"></i>
            </a>
        </p>

    </form>
@endsection
