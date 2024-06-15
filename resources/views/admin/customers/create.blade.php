@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Clientes</h4>
        <p>
            Todo cliente deve possuir um nível. Só é possível criar um cliente manualmente se já houver o mesmo cadastrado
            como usuário antes e tendo a função de 'Cliente' estabelecida na criação. Clientes podem ter conexões com
            orçamentos,
            carrinho de compras, vendas e
            seus endereços de entrega. Há a diferenciação de um cliente PF e PJ durante o registro.
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list customers')
            <a href="{{ route('customers.index') }}" class="btn btn-sm btn-primary">Listar clientes</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando cliente</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2create" id="user_id" name="user_id"
                            aria-label="Usuários com a função cliente">
                            <option value="" selected disabled>---Selecione ou crie---</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>

                        <label for="user_id">Usuários que tem a função 'Cliente'</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="customer_level_id"
                            name="customer_level_id" aria-label="Nível do cliente">
                            <option value="" selected disabled>---Selecione---</option>
                            @foreach ($levels as $level)
                                <option value="{{ $level->id }}"
                                    {{ old('customer_level_id') == $level->id ? 'selected' : '' }}>{{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="customer_level_id">Nível do cliente</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="telephone"
                            name="telephone" placeholder="Sem abreviações" value="{{ old('telephone') }}">
                        <label for="telephone">DDD + Telefone <i class="fa-solid fa-phone-volume"></i></label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="celphone"
                            name="celphone" placeholder="Sem abreviações" value="{{ old('celphone') }}">
                        <label for="celphone">DDD + Celular <i class="fa-solid fa-mobile-screen-button"></i></label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" role="switch" id="whatsappSign" name="whatsappSign"
                            {{ old('whatsappSign') ? 'checked' : '' }}>
                        <label class="form-check-label" for="whatsappSign">
                            <i class="fa-brands fa-whatsapp fa-xl text-success"></i> É número WhatsApp
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="type_buyer" name="type_buyer"
                            aria-label="Tipo de comprador">
                            <option value="" selected disabled>---Selecione---</option>
                            <option value="PF" {{ old('type_buyer') == 'PF' ? 'selected' : '' }}>Pessoa Física</option>
                            <option value="PJ" {{ old('type_buyer') == 'PJ' ? 'selected' : '' }}>Pessoa Jurídica
                            </option>
                        </select>
                        <label for="type_buyer">Tipo de comprador(a)</label>
                    </div>
                </div>
                <div class="col-md-3" id="pf-div">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="cpf"
                            name="cpf" placeholder="Sem abreviações" value="{{ old('cpf') }}">
                        <label for="cpf">CPF</label>
                    </div>
                </div>
            </div>
            <div id="pj-div" class="row justify-content-center mb-1">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="company"
                            name="company" placeholder="Sem abreviações" value="{{ old('company') }}">
                        <label for="company">Nome fantasia</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="cnpj"
                            name="cnpj" placeholder="Sem abreviações" value="{{ old('cnpj') }}">
                        <label for="cnpj">CNPJ</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="ie"
                            name="ie" placeholder="Sem abreviações" value="{{ old('ie') }}">
                        <label for="ie">Inscrição Estadual</label>
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
