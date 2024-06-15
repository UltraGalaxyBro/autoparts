@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Montadoras</h4>
        <p>As montadoras, além do propósito de auxiliar na organização e indicar a compatibilidade do veículo, são
            essenciais para construir o código interno de um
            produto.</p>
    </div>
    @can('list automakers')
        <div class="pt-3 pb-2 mb-3 text-end">
            <a href="{{ route('automakers.index') }}" class="btn btn-sm btn-secondary">Listar montadoras</a>
        </div>
    @endcan
    <div class="mb-5">
        <form action="{{ route('automakers.store') }}" method="POST">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando montadora</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="name" name="name"
                            placeholder="Sem abreviações" value="{{ old('name') }}">
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="shard_code" name="shard_code" placeholder="Insira"
                            value="{{ old('shard_code') }}" oninput="updateSpan()" pattern="/^-?\d+\.?\d*$/"
                            onKeyPress="if(this.value.length==2) return false;">
                        <label for="shard_code">#</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <p class="bg-secondary p-2 rounded-3 text-center fw-bold">Participação no código interno:<br>
                        <img src="{{ asset('img/logo.svg') }}" width="25px" height="25px" alt="Logo">
                        CO2-<span class="text-danger">XX</span><span id="showingShardCode" class="badge bg-primary"
                            style="font-size: 15px;">XX</span><span class="text-danger">XXX</span>
                    </p>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Cadastrar montadora" type="submit"
                     onclick="this.innerText = 'Cadastrando...'">Cadastrar</button>
            </div>
        </form>
    </div>
@endsection
