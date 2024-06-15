@extends('layouts.auth')

@section('content')
    <form action="{{ route('auth.recovering') }}" method="POST" id="recoveryForm"
        class="p-4 p-md-5 border rounded-3 bg-body-tertiary">
        @csrf
        @method('post')

        <h4 class="fw-bold text-center">Recuperar senha</h4>
        <div class="form-floating mb-3">
            <input type="email" class="form-control rounded-3" id="email" name="email" placeholder="nome@exemplo.com"
                value="{{ old('email') }}">
            <label for="email">E-mail cadastrado</label>
        </div>
        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary mb-2" type="submit"
            onclick="this.innerText = 'Recuperando...'">Recuperar</button>
        <hr class="my-4">
        <p>Já possui uma conta? <a href="{{ route('auth.login') }}" title="Recuperar senha"
                class="text-decoration-none badge text-bg-light fs-6">Ir ao login <i
                    class="fa-solid fa-arrow-pointer"></i></a></p>
    </form>
@endsection
