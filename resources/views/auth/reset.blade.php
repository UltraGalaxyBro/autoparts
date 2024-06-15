@extends('layouts.auth')

@section('content')
    <form action="{{ route('auth.resetting') }}" method="POST" id="resetForm"
        class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
        @csrf
        @method('post')

        <input type="hidden" name="token" value="{{ $token }}">

        <h4 class="fw-bold text-center">Redefinindo senha</h4>
        <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="nome@exemplo.com"
                value="{{ old('email') }}">
            <label for="email">E-mail cadastrado</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="password" name="password"
                placeholder="Escolha de senha segura">
            <label for="password">Nova senha</label>
        </div>
        <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="password_confirmation" name="password_confirmation"
                placeholder="Repita a senha">
            <label for="password_confirmation">Confirmar nova senha</label>
        </div>
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary mb-2" type="submit"
            onclick="this.innerText = 'Redefinindo...'">Redefinir</button>
        <hr class="my-4">
    </form>
@endsection
