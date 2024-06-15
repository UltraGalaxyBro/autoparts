@extends('layouts.admin')
@section('content')
    <div class="mb-5">
        <form action="{{ route('users.self-update', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('put')

            <h4 class="fw-bold text-center mb-3">Editando sua conta</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name', $user->name) }}">
                        <label for="name">Seu nome completo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="email" name="email"
                            placeholder="Sem abreviações" value="{{ old('email', $user->email) }}">
                        <label for="name">Seu e-mail</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="updatePassword" name="updatePassword"
                            aria-label="Resposta se irá alterar inclusive a senha do usuário">
                            <option value="Não" {{ old('updatePassword') == 'Não' ? 'selected' : '' }}>Não</option>
                            <option value="Sim" {{ old('updatePassword') == 'Sim' ? 'selected' : '' }}>Sim</option>
                        </select>
                        <label for="updatePassword">Necessário mudar sua senha</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1 conditional-div" style="display: none;">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="password" name="password"
                            placeholder="Sem abreviações" value="{{ old('password') }}">
                        <label for="password">Sua nova senha</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="password_confirmation"
                            name="password_confirmation" placeholder="Sem abreviações"
                            value="{{ old('password_confirmation') }}">
                        <label for="password_confirmation">Confirmar sua nova senha</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Editar usuário" type="submit"
                    onclick="this.innerText = 'Editando...'">Editar minha conta</button>
            </div>
        </form>
    </div>
@endsection
