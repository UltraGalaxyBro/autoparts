@extends('layouts.auth')

@section('content')
    <form action="{{ route('auth.store') }}" method="POST" id="signupForm"
        class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
        @csrf
        @method('post')

        <h4 class="fw-bold text-center">Criar conta</h4>
        <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="Sem abreviações"
                value="{{ old('name') }}">
            <label for="name">Nome completo</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" id="email" name="email"
                placeholder="nome@exemplo.com" value="{{ old('email') }}">
            <label for="email">E-mail</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="password" name="password"
                placeholder="Escolha de senha segura">
            <label for="password">Senha</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation"
                placeholder="Repita a senha">
            <label for="password_confirmation">Confirmar senha</label>
        </div>
        <div class="form-check text-start my-3">
            <input class="form-check-input" type="checkbox" id="agreed" name="agreed">
            <label class="form-check-label" for="agreed">
                <small>Concordo que li e aceito as <a href="{{ route('policies') }}" target="_blank">Políticas e Termos de
                        Uso</a> presentes neste site.</small>
            </label>
        </div>
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary mb-2" type="submit"
            onclick="this.innerText = 'Criando...'">Criar</button>
        <hr class="my-4">
        <p>Já possui uma conta? <a href="{{ route('auth.login') }}" title="Recuperar senha"
                class="text-decoration-none badge text-bg-light fs-6">Ir ao login <i
                    class="fa-solid fa-arrow-pointer"></i></a></p>
    </form>
@endsection
