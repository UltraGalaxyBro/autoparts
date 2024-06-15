@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Veículos</h4>
        <p>São essenciais para a funcionalidade de registrar corridas, pois toda corrida deve possuir um veículo em uso.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list vehicles')
            <a href="{{ route('vehicles.index') }}" class="btn btn-sm btn-secondary">Listar veículos cadastrados</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('vehicles.update', ['id' => $vehicle->id]) }}" method="POST">
            @csrf
            @method('put')

            <h4 class="fw-bold text-center mb-3">Editando veículo</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="type" name="type"
                            aria-label="Tipo do veículo.">
                            <option value="MOTO" {{ old('type', $vehicle->type) == 'MOTO' ? 'selected' : null }}>MOTO
                            </option>
                            <option value="CARRO" {{ old('type', $vehicle->type) == 'CARRO' ? 'selected' : null }}>CARRO
                            </option>
                            <option value="VAN" {{ old('type', $vehicle->type) == 'VAN' ? 'selected' : null }}>VAN
                            </option>
                            <option value="CAMINHÃO" {{ old('type', $vehicle->type) == 'CAMINHÃO' ? 'selected' : null }}>
                                CAMINHÃO</option>
                        </select>
                        <label for="type">Tipo do veículo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name', $vehicle->name) }}">
                        <label for="name">Nome/modelo do veículo</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="license_plate" name="license_plate"
                            placeholder="Sem abreviações" value="{{ old('license_plate', $vehicle->license_plate) }}"
                            oninput="this.value = this.value.toUpperCase()">
                        <label for="license_plate">Placa do veículo</label>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Editar veículo" type="submit"
                    onclick="this.innerText = 'Editando...'">Editar</button>
            </div>
        </form>
    </div>
@endsection
