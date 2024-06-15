@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Usuários</h4>
        <p>Os usuários podem ser aqueles que utilizam o sistema da CO2 Peças ou mesmo os que visitam o e-commerce. Existem
            níveis e cargos diferentes de usuários. É importante se atentar para quem você dará as permissões de acesso para
            determinadas áreas do sistema.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list users')
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-primary">Listar usuários</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando usuário</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name') }}">
                        <label for="name">Nome completo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="email" name="email"
                            placeholder="Sem abreviações" value="{{ old('email') }}">
                        <label for="name">E-mail</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="roles" name="roles"
                            aria-label="Sobre qual a função deste usuário">
                            <option value="" selected disabled>---Selecione---</option>
                            @foreach ($roles as $role)
                                @if ($role != 'Super Admin')
                                    <option value="{{ $role }}" {{ old('roles') == $role ? 'selected' : '' }}>
                                        {{ $role }}
                                    </option>
                                @else
                                    @if (Auth::user()->hasRole('Super Admin'))
                                        <option value="{{ $role }}" {{ old('roles') == $role ? 'selected' : '' }}>
                                            {{ $role }}
                                        </option>
                                    @endif
                                @endif
                            @endforeach
                        </select>
                        <label for="roles">Função</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-md-3 headquarter-unity" style="display: none;">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="headquarter_id" name="headquarter_id"
                            aria-label="Selecione a unidade em que este funcionário irá trabalhar">
                            <option value="" selected disabled>---Selecione---</option>
                            @foreach ($headquarters as $headquarter)
                                    <option value="{{ $headquarter->id }}" {{ old('headquarter_id') == $headquarter->id ? 'selected' : '' }}>
                                        {{ $headquarter->name }}, {{ $headquarter->city }}
                                    </option>
                            @endforeach
                        </select>
                        <label for="headquarter_id">Unidade em que fará parte</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="password" name="password"
                            placeholder="Sem abreviações" value="{{ old('password') }}">
                        <label for="password">Senha</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="password_confirmation"
                            name="password_confirmation" placeholder="Sem abreviações"
                            value="{{ old('password_confirmation') }}">
                        <label for="password_confirmation">Confirmar senha</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Cadastrar usuário" type="submit"
                    onclick="this.innerText = 'Cadastrando...'">Cadastrar</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var $selectVisible = $("#roles");
        $selectVisible.change(function() {
            var value = $(this).val();
            if (value !== "Cliente") {
                $(".headquarter-unity").show();
            } else {
                $(".headquarter-unity").hide();
            }
        });

        $selectVisible.change();
    });
</script>
@endpush
