@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Unidades da CO2</h4>
        <p>São através das unidades da CO2 Peças que algumas páginas são alimentadas com informações importantes sobre as
            localidades para um cliente chegar até uma loja autorizada da empresa ou se informar sobre onde está um
            produto dentre as possíveis opções. Por padrão sempre deve haver ao menos uma unidade cadastrada.</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list headquarters')
            <a href="{{ route('headquarters.index') }}" class="btn btn-sm btn-secondary">Listar unidades</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('headquarters.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando unidade</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="name"
                            name="name" placeholder="Sem abreviações" value="{{ old('name') }}">
                        <label for="name">Nome da unidade</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="state" name="state"
                            aria-label="Sobre em qual estado está localizado a unidade.">
                            <option value="">--</option>
                            <option value="AC" {{ old('state') == 'AC' ? 'selected' : null }}>AC</option>
                            <option value="AL" {{ old('state') == 'AL' ? 'selected' : null }}>AL</option>
                            <option value="AP" {{ old('state') == 'AP' ? 'selected' : null }}>AP</option>
                            <option value="AM" {{ old('state') == 'AM' ? 'selected' : null }}>AM</option>
                            <option value="BA" {{ old('state') == 'BA' ? 'selected' : null }}>BA</option>
                            <option value="CE" {{ old('state') == 'CE' ? 'selected' : null }}>CE</option>
                            <option value="DF" {{ old('state') == 'DF' ? 'selected' : null }}>DF</option>
                            <option value="ES" {{ old('state') == 'ES' ? 'selected' : null }}>ES</option>
                            <option value="GO" {{ old('state') == 'GO' ? 'selected' : null }}>GO</option>
                            <option value="MA" {{ old('state') == 'MA' ? 'selected' : null }}>MA</option>
                            <option value="MT" {{ old('state') == 'MT' ? 'selected' : null }}>MT</option>
                            <option value="MS" {{ old('state') == 'MS' ? 'selected' : null }}>MS</option>
                            <option value="MG" {{ old('state') == 'MG' ? 'selected' : null }}>MG</option>
                            <option value="PA" {{ old('state') == 'PA' ? 'selected' : null }}>PA</option>
                            <option value="PB" {{ old('state') == 'PB' ? 'selected' : null }}>PB</option>
                            <option value="PR" {{ old('state') == 'PR' ? 'selected' : null }}>PR</option>
                            <option value="PE" {{ old('state') == 'PE' ? 'selected' : null }}>PE</option>
                            <option value="PI" {{ old('state') == 'PI' ? 'selected' : null }}>PI</option>
                            <option value="RJ" {{ old('state') == 'RJ' ? 'selected' : null }}>RJ</option>
                            <option value="RN" {{ old('state') == 'RN' ? 'selected' : null }}>RN</option>
                            <option value="RS" {{ old('state') == 'RS' ? 'selected' : null }}>RS</option>
                            <option value="RO" {{ old('state') == 'RO' ? 'selected' : null }}>RO</option>
                            <option value="RR" {{ old('state') == 'RR' ? 'selected' : null }}>RR</option>
                            <option value="SC" {{ old('state') == 'SC' ? 'selected' : null }}>SC</option>
                            <option value="SP" {{ old('state') == 'SP' ? 'selected' : null }}>SP</option>
                            <option value="SE" {{ old('state') == 'SE' ? 'selected' : null }}>SE</option>
                            <option value="TO" {{ old('state') == 'TO' ? 'selected' : null }}>TO</option>
                        </select>
                        <label for="state">UF</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="city"
                            name="city" placeholder="Sem abreviações" value="{{ old('city') }}">
                        <label for="city">Cidade</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="neighborhood"
                            name="neighborhood" placeholder="Sem abreviações" value="{{ old('neighborhood') }}">
                        <label for="neighborhood">Bairro</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" maxlength="8" class="form-control rounded-3"
                            id="zip_code" name="zip_code" placeholder="" value="{{ old('zip_code') }}">
                        <label for="zip_code">CEP</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="street"
                            name="street" placeholder="Sem abreviações" value="{{ old('street') }}">
                        <label for="street">Rua/Avenida</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="number"
                            name="number" placeholder="" value="{{ old('number') }}">
                        <label for="number">Nº</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="complement"
                            name="complement" placeholder="" value="{{ old('complement') }}">
                        <label for="complement">Complemento</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="telephone"
                            name="telephone" placeholder="Sem abreviações" value="{{ old('telephone') }}">
                        <label for="telephone">Telefone</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="whatsapp"
                            name="whatsapp" placeholder="Sem abreviações" value="{{ old('whatsapp') }}">
                        <label for="whatsapp">Celular <i class="fa-brands fa-whatsapp text-success"></i></label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="visible" name="visible"
                            aria-label="Sobre tal unidade ficar visível aos usuários">
                            <option value="Sim" {{ old('visible') == 'Sim' ? 'selected' : null }}>Sim</option>
                            <option value="Não" {{ old('visible') == 'Não' ? 'selected' : null }}>Não</option>
                        </select>
                        <label for="visible">Visível</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="map"
                            name="map" placeholder="Sem abreviações" value="{{ old('map') }}">
                        <label for="map">Localização no Google Maps (link)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="coordinates"
                            name="coordinates" placeholder="Sem abreviações" value="{{ old('coordinates') }}">
                        <label for="coordinates">Coordenadas (latitude, longitude)</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-mb-2">
                    <div class="form-group text-center">
                        <label><small><strong>Imagem da fachada</strong></small></label>
                        <input type="file" value="" class="form-control-file" id="img" name="img"
                            placeholder="">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center mb-1">
                <div class="col-md-3 mb-2">
                    <img src="{{ asset('img/headquarters/default-image.png') }}" class="rounded" width="140"
                        height="140" id="targetImg" alt="Imagem representativa">
                    <button type="button" title="Remover esta imagem" id="imgDel" class="btn btn-danger"><i
                            class="fa-solid fa-file-circle-xmark"></i></button>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Cadastrar unidade" type="submit"
                     onclick="this.innerText = 'Cadastrando...'">Cadastrar</button>
            </div>
        </form>
    </div>
@endsection
