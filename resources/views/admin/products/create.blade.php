@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Produtos</h4>
        <p>A parte mais essencial do sistema na CO2 Peças. Os produtos são dependentes, para cadastro, da existência das
            unidades da CO2, categorias, montadoras e marcas. É possível, naturalmente, que um produto esteja em locais
            diferentes, ou seja, possuir mais de uma localização.
            <!--Quando há o cadastro de determinado produto de forma
                                                    correta é possível gerar orçamento e emissão de nota fiscal com o mesmo.-->
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        @can('list products')
            <a href="{{ route('products.index') }}" class="btn btn-sm btn-secondary">Listar produtos</a>
        @endcan
    </div>
    <div class="mb-5">
        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')

            <h4 class="fw-bold text-center mb-3">Cadastrando produto</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="name"
                            name="name" placeholder="Sem abreviações" value="{{ old('name') }}"
                            oninput="this.value = this.value.toUpperCase()">
                        <label for="name">Nome</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="category_id" name="category_id"
                            aria-label="Sobre qual a categoria do produto">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : null }}>
                                    {{ $category->name }} - {{ $category->shard_code }}
                                </option>
                            @endforeach
                        </select>
                        <label for="category_id">Categoria</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="automaker_id" name="automaker_id"
                            aria-label="Sobre qual a montadora do produto">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($automakers as $automaker)
                                <option value="{{ $automaker->id }}"
                                    {{ old('automaker_id') == $automaker->id ? 'selected' : null }}>{{ $automaker->name }} -
                                    {{ $automaker->shard_code }}
                                </option>
                            @endforeach
                        </select>
                        <label for="automaker_id">Montadora</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-floating mb-1">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="original_code"
                            name="original_code" placeholder="Sem abreviações" value="{{ old('original_code') }}"
                            oninput="this.value = this.value.toUpperCase()">
                        <label for="original_code">Código original</label>
                    </div>
                    <div class="form-check form-switch" id="original_code_null_div" style="display: none;">
                        <input class="form-check-input" type="checkbox" role="switch" id="original_code_null"
                            name="original_code_null" {{ old('original_code_null') ? 'checked' : '' }}>
                        <label class="form-check-label" for="original_code_null">
                            Código original nulo
                        </label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2create" id="brand_id" name="brand_id"
                            aria-label="Sobre qual a marca do produto">
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id') == $brand->id ? 'selected' : null }}>{{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="brand_id">Marca</label>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-floating mb-1">
                        <input autocomplete="off" type="text" class="form-control rounded-3" id="brand_code"
                            name="brand_code" placeholder="Sem abreviações" value="{{ old('brand_code') }}"
                            oninput="this.value = this.value.toUpperCase()">
                        <label for="brand_code">Código fabricante</label>
                    </div>
                    <div class="form-check form-switch" id="brand_code_null_div" style="display: none;">
                        <input class="form-check-input" type="checkbox" role="switch" id="brand_code_null"
                            name="brand_code_null" {{ old('brand_code_null') ? 'checked' : '' }}>
                        <label class="form-check-label" for="brand_code_null">
                            Código fabricante nulo
                        </label>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <textarea placeholder="Códigos similares a este produto" class="form-control rounded-3" id="cross_code"
                            name="cross_code" oninput="this.value = this.value.toUpperCase()">{{ old('cross_code') }}</textarea>
                        <label for="cross_code">Código(s) cruzado(s)</label>
                    </div>
                </div>
            </div>
            <div x-data="{
                locations: [
                    @if (count(old('locations', [])) > 0) @foreach (old('locations', []) as $oldLocation)
                            {
                                supplier_id: @if (isset($oldLocation['supplier_id'])) '{{ $oldLocation['supplier_id'] }}' @else '' @endif,
                    supplier_code: '{{ $oldLocation['supplier_code'] ?? '' }}',
                    headquarter_id: '{{ $oldLocation['headquarter_id'] ?? '' }}',
                    indoor_location: '{{ $oldLocation['indoor_location'] ?? '' }}',
                    quantity: '{{ $oldLocation['quantity'] ?? '' }}',
                    stock_alert_at: '{{ $oldLocation['stock_alert_at'] ?? '' }}'
                },
                @endforeach
                @else { supplier_id: '', supplier_code: '', headquarter_id: '', indoor_location: '', quantity: '', stock_alert_at: '' }
                @endif
            ]
            }"> <template x-for="(location, index) in locations" :key="index">
                    <div class="row justify-content-center mb-2">
                        <div class="mb-2">
                            <h6 class="text-center">Localização e Fornecimento <span x-text="index"></span>
                                <template x-if="locations.length > 1">
                                    <button type="button" title="Excluir localização para esse produto"
                                        class="btn btn-sm btn-danger" @click="locations.splice(index, 1)">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </template>
                            </h6>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <select autocomplete="off" class="form-select select2row" x-model="location.supplier_id"
                                    aria-label="Sobre qual a unidade da CO2 o produto está localizado"
                                    :name="'locations[' + index + '][supplier_id]'">
                                    <option value="" disabled selected>Selecione</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Fornecedor</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="location.supplier_code" :name="'locations[' + index + '][supplier_code]'"
                                    oninput="this.value = this.value.toUpperCase()">
                                <label>Código fornecedor</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <select autocomplete="off" class="form-select select2row"
                                    x-model="location.headquarter_id"
                                    aria-label="Sobre qual a unidade da CO2 o produto está localizado"
                                    :name="'locations[' + index + '][headquarter_id]'">
                                    @foreach ($headquarters as $headquarter)
                                        <option value="{{ $headquarter->id }}">
                                            {{ $headquarter->name }}, {{ $headquarter->city }}-{{ $headquarter->state }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Pertencente à unidade...</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="location.indoor_location" :name="'locations[' + index + '][indoor_location]'"
                                    oninput="this.value = this.value.toUpperCase()">
                                <label>Localização interna</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                                    x-model="location.quantity" :name="'locations[' + index + '][quantity]'">
                                <label>QTD.</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                                    x-model="location.stock_alert_at" :name="'locations[' + index + '][stock_alert_at]'">
                                <label>QTD. alerta (opcional)</label>
                            </div>
                        </div>
                        <div class="mb-2 text-center">
                            <template x-if="index === locations.length - 1">
                                <button type="button" title="Adicionar mais localização para esse produto"
                                    class="btn btn-sm btn-primary"
                                    @click="locations.push({ headquarter_id: '', indoor_location: '', quantity: '', stock_alert_at: '' });
                                    setTimeout(function() {
                                        $('.select2row').select2({
                                            theme: 'bootstrap-5'
                                        });
                                    }, 0);
                                    ">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="row justify-content-center mb-2">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="condition" name="condition"
                            aria-label="Sobre tal unidade ficar visível aos usuários">
                            <option value="Novo" {{ old('condition') == 'Novo' ? 'selected' : null }}>Novo</option>
                            <option value="Seminovo" {{ old('condition') == 'Seminovo' ? 'selected' : null }}>Seminovo
                            </option>
                        </select>
                        <label for="condition">Condição</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="measure" name="measure"
                            aria-label="Tipo da unidade de medida.">
                            <option value="UNID" {{ old('measure') == 'UNID' ? 'selected' : null }}>UNID</option>
                            <option value="KG" {{ old('measure') == 'KG' ? 'selected' : null }}>KG</option>
                            <option value="LT" {{ old('measure') == 'LT' ? 'selected' : null }}>LT</option>
                        </select>
                        <label for="measure">Medida</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="cost" name="cost" placeholder="" value="{{ old('cost') }}">
                        <label for="cost">Custo (R$)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="msc" name="msc" placeholder="" value="{{ old('msc') }}">
                        <label for="msc">MSC (%) <i class="fa-solid fa-calculator text-warning"></i></label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="price" name="price" placeholder="" value="{{ old('price') }}">
                        <label for="price">Preço (R$)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" class="form-control rounded-3" id="ncm"
                            name="ncm" placeholder="" value="{{ old('ncm') }}">
                        <label for="ncm">NCM</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-1">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="visible" name="visible"
                            aria-label="Sobre tal produto ficar visível aos usuários">
                            <option value="Não" {{ old('visible') == 'Não' ? 'selected' : null }}>Não</option>
                            <option value="Sim" {{ old('visible') == 'Sim' ? 'selected' : null }}>Sim</option>
                        </select>
                        <label for="visible">Visível em site</label>
                    </div>
                </div>
                <div class="col-md-5 conditional-div">
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" placeholder="Somente em site" id="aplication" name="aplication">{{ old('aplication') }}</textarea>
                        <label for="aplication">Aplicação</label>
                    </div>
                </div>
                <div class="col-md-3 conditional-div">
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" placeholder="Somente em site" id="description" name="description">{{ old('description') }}</textarea>
                        <label for="description">Descrição em site (opcional)</label>
                    </div>
                </div>
                <div class="col-md-2 conditional-div">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="sale" name="sale"
                            aria-label="Sobre tal produto ficar em promoção">
                            <option value="Não" {{ old('sale') == 'Não' ? 'selected' : null }}>Não</option>
                            <option value="Sim" {{ old('sale') == 'Sim' ? 'selected' : null }}>Sim</option>
                        </select>
                        <label for="sale">Habilitar promoção</label>
                    </div>
                </div>
            </div>
            <div class="conditional-div-2 row justify-content-center mb-2">
                <div class="col-md-6">
                    <div id="titleSale" class="form-text text-center">
                        Preencha os campos informando qual o valor promocional do produto aos clientes no<br>e-commerce,
                        além de informar até quando a promoção irá acabar.
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="discount" name="discount" placeholder="Número em porcentagem"
                            value="{{ old('discount') }}">
                        <label for="discount">Desconto (%) <i class="fa-solid fa-calculator text-warning"></i></label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="sale_price" name="sale_price" placeholder="Somente em site"
                            value="{{ old('sale_price') }}">
                        <label for="sale_price">Promoção (R$)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="date" class="form-control rounded-3" id="sale_period_until"
                            name="sale_period_until" placeholder="Somente em site"
                            value="{{ old('sale_period_until') }}">
                        <label for="sale_period_until">Promoção acaba em...</label>
                    </div>
                </div>
            </div>
            <div class="conditional-div row justify-content-center mb-1">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="height" name="height" placeholder="" value="{{ old('height') }}">
                        <label for="height">Altura (cm)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="width" name="width" placeholder="" value="{{ old('width') }}">
                        <label for="width">Largura (cm)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="lenght" name="lenght" placeholder="" value="{{ old('lenght') }}">
                        <label for="lenght">Comprimento (cm)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="weight" name="weight" placeholder="" value="{{ old('weight') }}">
                        <label for="weight">Peso (kg)</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="freight" name="freight"
                            aria-label="Sobre tal produto ficar visível aos usuários">
                            <option value="">--</option>
                            <option value="SÓ RETIRADA" {{ old('freight') == 'SÓ RETIRADA' ? 'selected' : null }}>SÓ
                                RETIRADA</option>
                            <option value="CORREIOS" {{ old('freight') == 'CORREIOS' ? 'selected' : null }}>CORREIOS
                            </option>
                            <option value="TRANSPORTADORA" {{ old('freight') == 'TRANSPORTADORA' ? 'selected' : null }}>
                                TRANSPORTADORA</option>
                        </select>
                        <label for="freight">Tipo de frete</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="packaging" name="packaging"
                            aria-label="Sobre tal produto ficar visível aos usuários">
                            <option value="">--</option>
                            <option value="CAIXA" {{ old('packaging') == 'CAIXA' ? 'selected' : null }}>CAIXA</option>
                            <option value="PLÁSTICO/ROLO" {{ old('packaging') == 'PLÁSTICO/ROLO' ? 'selected' : null }}>
                                PLÁSTICO/ROLO</option>
                            <option value="ENVELOPE" {{ old('packaging') == 'ENVELOPE' ? 'selected' : null }}>ENVELOPE
                            </option>
                            <option value="CAIXOTE" {{ old('packaging') == 'CAIXOTE' ? 'selected' : null }}>CAIXOTE
                            </option>
                            <option value="NÃO POSSUI" {{ old('packaging') == 'NÃO POSSUI' ? 'selected' : null }}>NÃO
                                POSSUI</option>
                        </select>
                        <label for="packaging">Embalagem</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center text-center mb-1">
                <div class="col-md-6">
                    <div class="form-group text-center">
                        <label><small><strong>Imagem</strong></small></label>
                        <input type="file" value="" class="form-control-file" id="img" name="img"
                            placeholder="">
                        <img src="{{ asset('img/products/default-image.png') }}" class="rounded" width="140"
                            height="140" id="targetImg" alt="Imagem representativa">
                        <button type="button" title="Remover esta imagem" id="imgDel"
                            class="btn btn-sm btn-danger imgDel">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div id="extra-img-1" class="form-group text-center mb-2" style="display:none;">
                        <label><small><strong>1ª imagem extra</strong></small></label>
                        <input type="file" value="" class="form-control-file" id="img1" name="img1"
                            placeholder="">
                        <img src="{{ asset('img/products/extra/default-image.png') }}" class="rounded" width="75"
                            height="75" id="targetImg1" alt="1ª imagem extra representativa">
                        <button type="button" title="Remover esta imagem" id="imgDel1"
                            class="btn btn-sm btn-danger imgDel">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </button>
                    </div>
                    <div id="extra-img-2" class="form-group text-center mb-2" style="display:none;">
                        <label><small><strong>2ª imagem extra</strong></small></label>
                        <input type="file" value="" class="form-control-file" id="img2" name="img2"
                            placeholder="">
                        <img src="{{ asset('img/products/extra/default-image.png') }}" class="rounded" width="75"
                            height="75" id="targetImg2" alt="2ª imagem extra representativa">
                        <button type="button" title="Remover esta imagem" id="imgDel2"
                            class="btn btn-sm btn-danger imgDel">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <button class="btn btn-lg btn-success rounded-3" title="Cadastrar produto" type="submit"
                    onclick="this.innerText = 'Cadastrando...'">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>
@endsection
