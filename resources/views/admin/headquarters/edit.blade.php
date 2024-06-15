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
        <form action="{{ route('headquarters.update', ['id' => $headquarter->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('put')

            <h4 class="fw-bold text-center mb-3">Editando unidade</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="name"
                            name="name" placeholder="Sem abreviações" value="{{ old('name', $headquarter->name) }}">
                        <label for="name">Nome da unidade</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="state" name="state"
                            aria-label="Sobre em qual estado está localizado a unidade.">
                            <option value="AC" {{ $headquarter->state == 'AC' ? 'selected' : null }}>AC</option>
                            <option value="AL" {{ $headquarter->state == 'AL' ? 'selected' : null }}>AL</option>
                            <option value="AP" {{ $headquarter->state == 'AP' ? 'selected' : null }}>AP</option>
                            <option value="AM" {{ $headquarter->state == 'AM' ? 'selected' : null }}>AM</option>
                            <option value="BA" {{ $headquarter->state == 'BA' ? 'selected' : null }}>BA</option>
                            <option value="CE" {{ $headquarter->state == 'CE' ? 'selected' : null }}>CE</option>
                            <option value="DF" {{ $headquarter->state == 'DF' ? 'selected' : null }}>DF</option>
                            <option value="ES" {{ $headquarter->state == 'ES' ? 'selected' : null }}>ES</option>
                            <option value="GO" {{ $headquarter->state == 'GO' ? 'selected' : null }}>GO</option>
                            <option value="MA" {{ $headquarter->state == 'MA' ? 'selected' : null }}>MA</option>
                            <option value="MT" {{ $headquarter->state == 'MT' ? 'selected' : null }}>MT</option>
                            <option value="MS" {{ $headquarter->state == 'MS' ? 'selected' : null }}>MS</option>
                            <option value="MG" {{ $headquarter->state == 'MG' ? 'selected' : null }}>MG</option>
                            <option value="PA" {{ $headquarter->state == 'PA' ? 'selected' : null }}>PA</option>
                            <option value="PB" {{ $headquarter->state == 'PB' ? 'selected' : null }}>PB</option>
                            <option value="PR" {{ $headquarter->state == 'PR' ? 'selected' : null }}>PR</option>
                            <option value="PE" {{ $headquarter->state == 'PE' ? 'selected' : null }}>PE</option>
                            <option value="PI" {{ $headquarter->state == 'PI' ? 'selected' : null }}>PI</option>
                            <option value="RJ" {{ $headquarter->state == 'RJ' ? 'selected' : null }}>RJ</option>
                            <option value="RN" {{ $headquarter->state == 'RN' ? 'selected' : null }}>RN</option>
                            <option value="RS" {{ $headquarter->state == 'RS' ? 'selected' : null }}>RS</option>
                            <option value="RO" {{ $headquarter->state == 'RO' ? 'selected' : null }}>RO</option>
                            <option value="RR" {{ $headquarter->state == 'RR' ? 'selected' : null }}>RR</option>
                            <option value="SC" {{ $headquarter->state == 'SC' ? 'selected' : null }}>SC</option>
                            <option value="SP" {{ $headquarter->state == 'SP' ? 'selected' : null }}>SP</option>
                            <option value="SE" {{ $headquarter->state == 'SE' ? 'selected' : null }}>SE</option>
                        </select>
                        <label for="state">UF</label>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="city"
                            name="city" placeholder="Sem abreviações" value="{{ old('city', $headquarter->city) }}">
                        <label for="city">Cidade</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="neighborhood"
                            name="neighborhood" placeholder="Sem abreviações"
                            value="{{ old('neighborhood', $headquarter->neighborhood) }}">
                        <label for="neighborhood">Bairro</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" maxlength="8" class="form-control rounded-3"
                            id="zip_code" name="zip_code" placeholder=""
                            value="{{ old('zip_code', $headquarter->zip_code) }}">
                        <label for="zip_code">CEP</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="street"
                            name="street" placeholder="Sem abreviações" value="{{ old('street', $headquarter->street) }}">
                        <label for="street">Rua/Avenida</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="number"
                            name="number" placeholder="" value="{{ old('number', $headquarter->number) }}">
                        <label for="number">Nº</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="complement"
                            name="complement" placeholder="" value="{{ old('complement', $headquarter->complement) }}">
                        <label for="complement">Complemento</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="telephone"
                            name="telephone" placeholder="Sem abreviações"
                            value="{{ old('telephone', $headquarter->telephone) }}">
                        <label for="telephone">Telefone</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="whatsapp"
                            name="whatsapp" placeholder="Sem abreviações"
                            value="{{ old('whatsapp', $headquarter->whatsapp) }}">
                        <label for="whatsapp">Celular <i class="fa-brands fa-whatsapp text-success"></i></label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="visible" name="visible"
                            aria-label="Sobre tal unidade ficar visível aos usuários">
                            <option value="Sim" {{ $headquarter->visible == 'Sim' ? 'selected' : null }}>Sim</option>
                            <option value="Não" {{ $headquarter->visible == 'Não' ? 'selected' : null }}>Não</option>
                        </select>
                        <label for="visible">Visível</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="map"
                            name="map" placeholder="Sem abreviações" value="{{ old('map', $headquarter->map) }}">
                        <label for="map">Localização no Google Maps (link)</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="coordinates"
                            name="coordinates" placeholder="Sem abreviações"
                            value="{{ old('coordinates', $headquarter->coordinates) }}">
                        <label for="coordinates">Coordenadas (latitude, longitude)</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-mb-2">
                    <div class="form-group text-center">
                        <label><small><strong>Imagem da fachada</strong></small></label>
                        <input type="file" class="form-control-file" id="img" name="img" placeholder="">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center mb-1">
                <div class="col-md-3 mb-2">
                    <img src="{{ asset('img/headquarters/' . $headquarter->main_img) }}" class="rounded" width="140"
                        height="140" id="targetImg" alt="Imagem representativa">
                    <button type="button" title="Remover esta imagem" id="imgDel" class="btn btn-danger"><i
                            class="fa-solid fa-file-circle-xmark"></i></button>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Editar unidade" type="submit"
                     onclick="this.innerText = 'Editando...'">Editar</button>
            </div>
        </form>
    </div>
@endsection
