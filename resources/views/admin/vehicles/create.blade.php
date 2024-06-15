@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Veículos</h4>
        <p>São essenciais para a funcionalidade de registrar corridas, pois toda corrida deve possuir um veículo em uso.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-secondary">Listar veículos cadastrados</a>
    </div>
    <div class="mb-5">
        <form action="{{ route('vehicles.store') }}" method="POST">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando veículo</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="type" name="type"
                            aria-label="Tipo do veículo.">
                            <option value="" selected disabled>--Selecione--</option>
                            <option value="MOTO" {{ old('type') == 'MOTO' ? 'selected' : null }}>MOTO</option>
                            <option value="CARRO" {{ old('type') == 'CARRO' ? 'selected' : null }}>CARRO</option>
                            <option value="VAN" {{ old('type') == 'VAN' ? 'selected' : null }}>VAN</option>
                            <option value="CAMINHÃO" {{ old('type') == 'CAMINHÃO' ? 'selected' : null }}>CAMINHÃO</option>
                        </select>
                        <label for="type">Tipo do veículo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name') }}">
                        <label for="name">Nome/modelo do veículo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="license_plate" name="license_plate"
                            placeholder="Sem abreviações" value="{{ old('license_plate') }}"
                            oninput="this.value = this.value.toUpperCase()">
                        <label for="license_plate">Placa do veículo</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Cadastrar veículo" type="submit"
                    onclick="this.innerText = 'Cadastrando...'">Cadastrar</button>
            </div>
        </form>
    </div>
@endsection
