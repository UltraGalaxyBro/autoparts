@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Cotações</h4>
        <p>
            É possível emitir cotações aos clientes ou mesmo ter cotações para responder quando algum cliente solicita por
            meio do site da CO2 Peças. É necessário haver previamente criado o cliente no qual será respondida/criada a
            cotação. Vale informar que campos com o símbolo <i class="fa-solid fa-eye-slash"></i> não ficarão aparentes ao
            cliente na cotação, enquanto que com o símbolo <i class="fa-solid fa-o text-warning"></i> são opcionais.
            Existem algumas opções autoexplicativas sobre o campo de fornecedor:
            @foreach ($specialSuppliers as $specialSupplier)
                <strong>{{ $specialSupplier->name }}</strong>
            @endforeach
        </p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <a href="{{ route('budgets.index') }}" class="btn btn-sm btn-secondary">Listar cotações</a>
    </div>
    <div class="mb-5">
        <form action="{{ route('budgets.update', ['id' => $budget->id]) }}" method="POST">
            @csrf
            @method('put')

            <h4 class="fw-bold text-center mb-3">Editando cotação</h4>
            <div class="row justify-content-center mb-2">
                <div class="col-md-3">
                    @if (auth()->user()->hasRole('Super Admin') || auth()->user()->hasRole('Admin'))
                        <div class="form-floating mb-3">
                            <select autocomplete="off" class="form-select select2" id="user_id" name="user_id"
                                aria-label="Sobre qual a categoria do produto">
                                @foreach ($sellers as $seller)
                                    <option value="{{ $seller->id }}"
                                        {{ old('user_id', $seller->id) == $budget->user_id ? 'selected' : null }}>
                                        {{ $seller->name }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="user_id">Vendedor(a) responsável</label>
                        </div>
                    @else
                        <div class="form-floating mb-3">
                            <select autocomplete="off" class="form-select" id="user_id" name="user_id"
                                aria-label="Sobre quem está responsável pela cotação">
                                <option value="{{ $budget->user_id }}" selected>
                                    {{ $budget->user->name }}
                                </option>
                            </select>
                            <label for="user_id">Vendedor(a) responsável</label>
                        </div>
                    @endif
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select select2" id="customer_id" name="customer_id"
                            aria-label="Sobre qual a categoria do produto">
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('customer_id', $client->id) == $budget->customer_id ? 'selected' : null }}>
                                    {{ $client->user->name }}
                                    @if ($client->type_buyer == 'PJ')
                                        ({{ $client->company }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        <label for="customer_id">Cliente solicitante</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="date" class="form-control rounded-3" id="validity"
                            name="validity" placeholder="Aparecerá para o cliente"
                            value="{{ old('validity', \Carbon\Carbon::parse($budget->validity)->toDateString()) }}"
                            min="{{ \Carbon\Carbon::now()->toDateString() }}">
                        <label for="validity">Validade da cotação até...</label>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-2">
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="payment_method" name="payment_method"
                            aria-label="Tipo da unidade de medida.">
                            <option value="PIX"
                                {{ old('payment_method', $budget->payment_method) == 'PIX' ? 'selected' : null }}>PIX
                            </option>
                            <option value="BOLETO"
                                {{ old('payment_method', $budget->payment_method) == 'BOLETO' ? 'selected' : null }}>BOLETO
                            </option>
                            <option value="CARTÃO DE CRÉDITO"
                                {{ old('payment_method', $budget->payment_method) == 'CARTÃO DE CRÉDITO' ? 'selected' : null }}>
                                CARTÃO DE CRÉDITO
                            </option>
                            <option value="CHEQUE"
                                {{ old('payment_method', $budget->payment_method) == 'CHEQUE' ? 'selected' : null }}>CHEQUE
                            </option>
                        </select>
                        <label for="payment_method">Forma de pagamento</label>
                    </div>
                </div>
                <div class="col-md-2" id="details-bol-div" style="display: none;">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="payment_details_bol" name="payment_details_bol"
                            aria-label="Tipo da unidade de medida.">
                            <option value="3"
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '3' ? 'selected' : null }}>3
                            </option>
                            <option value='15'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '15' ? 'selected' : null }}>
                                15</option>
                            <option value='20'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '20' ? 'selected' : null }}>
                                20
                            </option>
                            <option value='28'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '28' ? 'selected' : null }}>
                                28</option>
                            <option value='30'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '30' ? 'selected' : null }}>
                                30</option>
                            <option value='15/30'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '15/30' ? 'selected' : null }}>
                                15/30
                            </option>
                            <option value='15/30/45'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '15/30/45' ? 'selected' : null }}>
                                15/30/45</option>
                            <option value='20/40'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '20/40' ? 'selected' : null }}>
                                20/40
                            </option>
                            <option value='20/40/60'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '20/40/60' ? 'selected' : null }}>
                                20/40/60
                            </option>
                            <option value='28/56'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '28/56' ? 'selected' : null }}>
                                28/56
                            </option>
                            <option value='28/56/84'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '28/56/84' ? 'selected' : null }}>
                                28/56/84</option>
                            <option value='28/56/84/112'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '28/56/84/112' ? 'selected' : null }}>
                                28/56/84/112
                            </option>
                            <option value='30/45'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '30/45' ? 'selected' : null }}>
                                30/45</option>
                            <option value='30/45/60'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '30/45/60' ? 'selected' : null }}>
                                30/45/60</option>
                            <option value='30/60'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '30/60' ? 'selected' : null }}>
                                30/60
                            </option>
                            <option value='30/60/90'
                                {{ old('payment_details_bol', $budget->payment_details_bol) == '30/60/90' ? 'selected' : null }}>
                                30/60/90</option>
                        </select>
                        <label for="payment_details_bol">Intervalo (em dias)</label>
                    </div>
                </div>
                <div class="col-md-2" id="details-credit-div" style="display: none;">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="payment_details_credit"
                            name="payment_details_credit" aria-label="Tipo da unidade de medida.">
                            <option value="" selected disabled>--Selecione--</option>
                            <option value="1X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '1X' ? 'selected' : null }}>
                                1X
                            </option>
                            <option value="2X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '2X' ? 'selected' : null }}>
                                2X
                            </option>
                            <option value="3X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '3X' ? 'selected' : null }}>
                                3X
                            </option>
                            <option value="4X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '4X' ? 'selected' : null }}>
                                4X
                            </option>
                            <option value="5X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '5X' ? 'selected' : null }}>
                                5X
                            </option>
                            <option value="6X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '6X' ? 'selected' : null }}>
                                6X
                            </option>
                            <option value="7X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '7X' ? 'selected' : null }}>
                                7X
                            </option>
                            <option value="8X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '8X' ? 'selected' : null }}>
                                8X
                            </option>
                            <option value="9X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '9X' ? 'selected' : null }}>
                                9X
                            </option>
                            <option value="10X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '10X' ? 'selected' : null }}>
                                10X
                            </option>
                            <option value="11X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '11X' ? 'selected' : null }}>
                                11X
                            </option>
                            <option value="12X"
                                {{ old('payment_details_credit', $budget->payment_details_credit) == '12X' ? 'selected' : null }}>
                                12X
                            </option>
                        </select>
                        <label for="payment_details_credit">Limite de parcelas</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <select autocomplete="off" class="form-select" id="freight_type" name="freight_type"
                            aria-label="Tipo da unidade de medida.">
                            <option value="CIF"
                                {{ old('freight_type', $budget->freight_type) == 'CIF' ? 'selected' : null }}>
                                CIF (Cliente paga)
                            </option>
                            <option value="FOB"
                                {{ old('freight_type', $budget->freight_type) == 'FOB' ? 'selected' : null }}>
                                FOB (CO2 paga)
                            </option>
                            <option value="RETIRADA EM LOJA"
                                {{ old('freight_type', $budget->freight_type) == 'RETIRADA EM LOJA' ? 'selected' : null }}>
                                RETIRADA EM LOJA
                            </option>
                        </select>
                        <label for="freight_type">Tipo de frete</label>
                    </div>
                </div>
                <div class="col-md-2 mb-3" id="freight-price-div" style="display: none;">
                    <div class="form-floating">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="freight_price" name="freight_price" placeholder="Preço do frete em CIF"
                            value="{{ old('freight_price', $budget->freight_price) }}">
                        <label for="freight_price">Valor frete (R$)</label>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="freight_price_null"
                            name="freight_price_null"
                            {{ old('freight_price_null') || !$budget->freight_price ? 'checked' : '' }}>
                        <label class="form-check-label" for="freight_price_null">
                            Ainda sem cálculo
                        </label>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="form-floating">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            id="expenses" name="expenses" value="{{ old('expenses', $budget->expenses) }}"
                            placeholder="Se necessário">
                        <label for="expenses">Despesas (R$) <i class="fa-solid fa-o text-warning"></i></label>
                    </div>
                </div>
            </div>
            <div x-data="{
                products: [
                    @if (count(old('products', $budgetItems)) > 0) @foreach (old('products', $budgetItems) as $oldProduct)
                            {
                                description: '{{ $oldProduct['description'] ?? '' }}',
                                supplier_id: '{{ $oldProduct['supplier_id'] ?? '' }}',
                                supplier_reference: '{{ $oldProduct['supplier_reference'] ?? '' }}',
                                cost: '{{ $oldProduct['cost'] ?? '' }}',
                                deadline: '{{ $oldProduct['deadline'] ?? '' }}',
                                price: '{{ $oldProduct['price'] ?? '' }}',
                                quantity: '{{ $oldProduct['quantity'] ?? '' }}'
                            },
                        @endforeach
                    @else
                        @foreach ($budgetItems as $budgetItem)
                            {
                                description: '{{ $budgetItem['description'] ?? '' }}',
                                supplier_id: '{{ $budgetItem['supplier_id'] ?? '' }}',
                                supplier_reference: '{{ $budgetItem['supplier_reference'] ?? '' }}',
                                cost: '{{ $budgetItem['cost'] ?? '' }}',
                                deadline: '{{ $budgetItem['deadline'] ?? '' }}',
                                price: '{{ $budgetItem['price'] ?? '' }}',
                                quantity: '{{ $budgetItem['quantity'] ?? '' }}'
                            },
                        @endforeach @endif
                ],
                toggleMSC: function(productIndex) {
                    let product = this.products[productIndex];
                    if (!product.cost && product.showMSC) {
                        product.showMSC = false;
                    } else {
                        product.showMSC = !product.showMSC;
                    }
                },
                calculatePrice: function(productIndex) {
                    let product = this.products[productIndex];
                    let msc = parseFloat(product.msc);
                    let cost = parseFloat(product.cost);
                    if (!isNaN(msc) && !isNaN(cost)) {
                        product.price = (cost + (cost * msc / 100)).toFixed(2);
                    } else {
                        product.price = '';
                    }
                },
                hideMSC: function() {
                    this.products.forEach(function(product) {
                        product.showMSC = false;
                    });
                }
            }" x-init="document.addEventListener('click', function(event) {
                if (!event.target.closest('.input-group')) {
                    hideMSC();
                }
            })">
                <template x-for="(product, index) in products" :key="index">
                    <div class="row justify-content-center mb-2">
                        <div class="mb-2">
                            <h6 class="text-center fw-bold">Produto <span x-text="index"></span>
                                <template x-if="products.length > 1">
                                    <button type="button" title="Excluir produto da cotação"
                                        class="btn btn-sm btn-danger btn-delete-row-product"
                                        @click="products.splice(index, 1);">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </template>
                            </h6>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="product.description" :name="'products[' + index + '][description]'"
                                    oninput="this.value = this.value.toUpperCase().replace(/'/g, '.')">
                                <label>Descrição da peça</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <select autocomplete="off" class="form-select select2row" x-model="product.supplier_id"
                                    aria-label="Sobre qual a unidade da CO2 o produto está localizado"
                                    :name="'products[' + index + '][supplier_id]'">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label>Fornecedor <i class="fa-solid fa-eye-slash"></i></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" class="form-control rounded-3"
                                    x-model="product.supplier_reference"
                                    :name="'products[' + index + '][supplier_reference]'"
                                    oninput="this.value = this.value.toUpperCase().replace(/'/g, '.')">
                                <label>Ref. fornecedor <i class="fa-solid fa-eye-slash"></i> <i
                                        class="fa-solid fa-o text-warning"></i></label>
                            </div>
                        </div>
                        <div class="col-md-2 mb-3">
                            <div class="input-group">
                                <div class="form-floating">
                                    <input autocomplete="off" type="number" step="0.01"
                                        class="form-control rounded-start-3" x-model="product.cost"
                                        @input="calculatePrice(index)" :name="'products[' + index + '][cost]'">
                                    <label for="costInput">Custo (R$) <i class="fa-solid fa-eye-slash"></i></label>
                                </div>
                                <button class="btn btn-light" type="button" @click="toggleMSC(index)"
                                    :disabled="!product.cost">
                                    <i class="fa-solid fa-calculator"></i>
                                </button>
                            </div>
                            <div x-show="product.showMSC" class="input-group input-group-sm">
                                <input autocomplete="off" placeholder="Calcular MSC" type="number" step="0.01"
                                    class="form-control" x-model="product.msc" @input="calculatePrice(index)">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" value="" class="form-control rounded-3"
                                    x-model="product.deadline" :name="'products[' + index + '][deadline]'">
                                <label>Prazo dias</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                                    x-model="product.price" :name="'products[' + index + '][price]'">
                                <label>Preço (R$)</label>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="number" class="form-control rounded-3"
                                    x-model="product.quantity" :name="'products[' + index + '][quantity]'">
                                <label>QTD.</label>
                            </div>
                        </div>
                        <div class="mb-2 text-center">
                            <template x-if="index === products.length - 1">
                                <button type="button" title="Adicionar produto à cotação"
                                    class="btn btn-sm btn-primary btn-add-row-product"
                                    @click="products.push({ description: '', supplier_id: '', supplier_reference: '', cost: '', deadline: '1', price: '', quantity: '1' }); 
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
            <div class="row justify-content-center mb-3 mt-5">
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" oninput="this.value = this.value.toUpperCase()"
                            placeholder="Somente em site" id="chassis_number" name="chassis_number">{{ old('chassis_number', $budget->chassis_number) }}</textarea>
                        <label for="chassis_number">Nº do chassi <i class="fa-solid fa-o text-warning"></i></label>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-floating mb-3">
                        <textarea class="form-control rounded-3" placeholder="Somente em site" id="observation" name="observation">{{ old('observation', $budget->observation) }}</textarea>
                        <label for="observation">Observação da cotação ao cliente <i
                                class="fa-solid fa-o text-warning"></i></label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-floating mb-3">
                        <input autocomplete="off" type="number" step="0.01" class="form-control rounded-3"
                            name="discount" id="discount" value="{{ old('discount', $budget->discount) }}">
                        <label>Desconto (R$) <i class="fa-solid fa-o text-warning"></i></label>
                    </div>
                </div>
            </div>

            <input type="hidden" id="total_price" name="total_price" value="{{ $budget->total_price }}">

            <div class="text-center">
                <button class="btn btn-lg btn-success rounded-3" title="Editar cotação" type="submit"
                    onclick="this.innerText = 'Editando...'">Editar cotação</button>
            </div>
        </form>
    </div>

    <div class="position-fixed bottom-0 end-0 me-3 total-cost-budget">
        <span id="total-cost-indicator-bg" class="text-center badge">
            <span class="fw-bold">Custo produtos <i class="fa-solid fa-eye-slash"></i></span>
            <h6 class="fw-bold mt-1">
                R$ <span id="total-cost-indicator"></span>
            </h6>
        </span>
    </div>

    <div class="position-fixed bottom-0 end-0 me-3 total-price-budget">
        <span id="total-price-indicator-bg" class="text-center badge">
            <h6 class="fw-bold">Venda total<br>
                R$ <span id="total-price-indicator"></span>
            </h6>
        </span>
    </div>
@endsection
