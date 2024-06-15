@extends('layouts.admin')
@section('content')
    <div class="mb-3">
        <h4>Cotações</h4>
        <p>É possível emitir cotações aos clientes ou mesmo ter cotações para responder quando algum cliente solicita por
            meio do site da CO2 Peças. É necessário haver previamente criado o cliente no qual será respondida/criada a
            cotação. Vale informar que campos com o símbolo <i class="fa-solid fa-eye-slash"></i> não ficarão aparentes ao
            cliente na cotação</p>
    </div>
    <div class="pt-3 pb-2 mb-3 text-end">
        <form action="{{ route('budgets.transform', ['id' => $budget->id]) }}" method="POST">
            @csrf
            @method('put')

            <input type="hidden" name="sign_status" value="{{ $budget->status }}">
            @if ($budget->status == 'VENDIDA')
                <button type="submit" class="btn btn-sm btn-light mb-1" onclick="this.innerText = 'Desfazendo...'"
                    title="Converter que houve venda">
                    <i class="fa-solid fa-rotate-left"></i> Desfazer sinalização de venda
                </button>
            @else
                <button type="submit" class="btn btn-sm btn-success mb-1" onclick="this.innerText = 'Sinalizando...'"
                    title="Converter que houve venda">
                    <i class="fa-solid fa-money-check-dollar"></i> Sinalizar que houve venda
                </button>
            @endif
        </form>
        @can('edit budget')
            <a href="{{ route('budgets.edit', ['id' => $budget->id]) }}" class="btn btn-sm btn-warning mb-1" title="Editar">
                <i class="fa-solid fa-pen"></i>
            </a>
        @endcan
        @can('list budgets')
            <a href="{{ route('budgets.index') }}" class="btn btn-sm btn-secondary mb-1">Listar cotações</a>
        @endcan
        <form action="{{ route('budgets.generatePdf') }}" method="POST">
            @csrf
            @method('post')
            <input type="hidden" value="{{ $budget->id }}" id="budget_id" name="budget_id">
            <button type="submit" class="btn btn-sm btn-danger" title="Gerar PDF da cotação">
                <i class="fa-regular fa-file-pdf"></i>
                Gerar PDF da cotação</button>
        </form>
    </div>
    <div class="mb-5 mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card bg-white text-dark position-relative">
                    @if ($budget->status == 'CONCLUÍDA')
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-2 bg-primary fw-bold text-light border border-light rounded-circle">
                            {{ $budget->status }}
                        </span>
                    @elseif ($budget->status == 'VENDIDA')
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-2 bg-success fw-bold text-light border border-light rounded-circle">
                            {{ $budget->status }}
                        </span>
                    @elseif ($budget->status == 'EM ANDAMENTO')
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-2 bg-warning fw-bold text-light border border-light rounded-circle">
                            <small>{{ $budget->status }}</small>
                        </span>
                    @else
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-2 bg-secondary fw-bold text-light border border-light rounded-circle">
                            {{ $budget->status }}
                        </span>
                    @endif

                    <div class="row justify-content-center align-items-center mt-5 mb-5">
                        <div class="col-12 col-md-4 text-center mb-3 mb-md-0">
                            <img src="{{ asset('img/logo.png') }}" alt="Logo CO2 Peças" class="img-fluid" width="60"
                                height="60">
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            <h5 class="text-center mb-0">
                                Cotação criada em
                                <span class="fw-bold d-block">
                                    {{ \Carbon\Carbon::parse($budget->created_at)->tz('America/Sao_Paulo')->format('d/m/Y') }}
                                </span>
                            </h5>
                        </div>
                        <div class="col-12 col-md-4 text-center">
                            <h5 class="text-center mb-0">
                                <span class="fw-bold d-block">
                                    ID {{ str_pad($budget->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                            </h5>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="form-group row mb-2">
                            <label for="validity" class="col-md-4 col-form-label fw-bold text-md-right">Vendedor(a)</label>
                            <div class="col-md-6">
                                @if ($budget->user_id)
                                    <input id="validity" type="text" value="{{ $budget->user->name }}"
                                        class="form-control text-center" readonly>
                                @else
                                    <input id="validity" type="text" value="NULO" class="form-control text-center"
                                        readonly>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="customer_id" class="col-md-4 col-form-label fw-bold text-md-right">Cliente</label>
                            <div class="col-md-6">
                                @if ($budget->customer->type_buyer == 'PJ')
                                    <div class="input-group">
                                        <input type="text" id="customer_id" value="{{ $budget->customer->user->name }}"
                                            class="form-control text-center" readonly>
                                        <input type="text" value="{{ $budget->customer->company }}"
                                            class="form-control text-center" readonly>
                                    </div>
                                @else
                                    <input type="text" id="customer_id" value="{{ $budget->customer->user->name }}"
                                        class="form-control text-center" readonly>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="customer_id" class="col-md-4 col-form-label fw-bold text-md-right">Data validade da
                                cotação</label>
                            <div class="col-md-6">
                                <input id="validity" type="text"
                                    value="{{ \Carbon\Carbon::parse($budget->validity)->tz('America/Sao_Paulo')->format('d/m/Y') }}"
                                    class="form-control text-center" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="payment_method" class="col-md-4 col-form-label fw-bold text-md-right">Método de
                                pagamento
                                preferível</label>
                            <div class="col-md-6">
                                @if ($budget->payment_method == 'BOLETO')
                                    <div class="input-group">
                                        <input type="text" id="payment_method" value="{{ $budget->payment_method }}"
                                            class="form-control text-center" readonly>
                                        <input type="text" value="{{ $budget->payment_details_bol }}"
                                            class="form-control text-center" readonly>
                                    </div>
                                @elseif ($budget->payment_method == 'CARTÃO DE CRÉDITO')
                                    <div class="input-group">
                                        <input type="text" id="payment_method" value="{{ $budget->payment_method }}"
                                            class="form-control text-center" readonly>
                                        <input type="text" value="{{ $budget->payment_details_credit }}"
                                            class="form-control text-center" readonly>
                                    </div>
                                @else
                                    <input type="text" id="payment_method" value="{{ $budget->payment_method }}"
                                        class="form-control text-center" readonly>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-2">
                            <label for="freight_type" class="col-md-4 col-form-label fw-bold text-md-right">Tipo e valor
                                frete (se
                                houver)</label>
                            <div class="col-md-6">
                                @if ($budget->freight_type == 'CIF')
                                    <div class="input-group">
                                        <input type="text" id="freight_type" value="{{ $budget->freight_type }}"
                                            class="form-control text-center" readonly>
                                        <input type="text"
                                            value="{{ $budget->freight_price ? 'R$ ' . number_format($budget->freight_price, 2, ',', '.') : 'A CALCULAR' }}"
                                            class="form-control text-center" readonly>

                                    </div>
                                @else
                                    <input type="text" id="freight_type" value="{{ $budget->freight_type }}"
                                        class="form-control text-center" readonly>
                                @endif
                            </div>
                        </div>
                        @if ($budget->expenses)
                            <div class="form-group row mb-2">
                                <label for="customer_id"
                                    class="col-md-4 col-form-label fw-bold text-md-right">Despesas</label>
                                <div class="col-md-6">
                                    <input id="expenses" type="text"
                                        value="R$ {{ number_format($budget->expenses, 2, ',', '.') }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                        @endif
                        @if ($budget->discount)
                            <div class="form-group row mb-2">
                                <label for="customer_id"
                                    class="col-md-4 col-form-label fw-bold text-md-right">Desconto</label>
                                <div class="col-md-6">
                                    <input id="discount" type="text"
                                        value="- R$ {{ number_format($budget->discount, 2, ',', '.') }}"
                                        class="form-control text-center" readonly>
                                </div>
                            </div>
                        @endif
                        @if ($budget->chassis_number)
                            <div class="form-group row mb-2">
                                <label for="chassis_number" class="col-md-4 col-form-label fw-bold text-md-right">Nº
                                    Chassi</label>
                                <div class="col-md-6">
                                    <textarea id="chassis_number" class="form-control" readonly>
                                        {{ $budget->chassis_number }}
                                    </textarea>
                                </div>
                            </div>
                        @endif
                        @if ($budget->observation)
                            <div class="form-group row mb-2">
                                <label for="observation" class="col-md-4 col-form-label fw-bold text-md-right">
                                    Observação
                                </label>
                                <div class="col-md-6">
                                    <textarea id="observation" class="form-control" readonly>
                                        {{ $budget->observation }}
                                    </textarea>
                                </div>
                            </div>
                        @endif
                        <div class="form-group row mb-2">
                            <label for="total_price" class="col-md-4 col-form-label fw-bold text-md-right">TOTAL DA
                                COTAÇÃO</label>
                            <div class="col-md-6">
                                <input id="total_price" type="text"
                                    value="R$ {{ number_format($budget->total_price, 2, ',', '.') }}"
                                    class="form-control text-center" readonly>
                            </div>
                        </div>
                        <hr>
                        <div class="text-end mb-1">
                            <a href="{{ route('budgets.clone', ['id' => $budget->id]) }}" class="btn btn-sm btn-primary"
                                title="Clonar">
                                <i class="fa-solid fa-clone"></i> Replicar produtos em nova cotação
                            </a>
                        </div>
                        <h4 class="text-center text-dark">Produto(s) na cotação</h4>
                        <div class="table-responsive">
                            <form action="{{ route('budgets.reportItems') }}" method="post">
                                @csrf
                                @method('post')

                                <table class="table table-bordered">
                                    <thead style="font-size: 9px;">
                                        <tr class="align-middle text-center">
                                            <th>
                                                <button type="button" class="btn btn-outline-info btn-sm"
                                                    title="Selecionar todos os produtos cotados">
                                                    <i class="fa-solid fa-check-to-slot"></i>
                                                </button>
                                            </th>
                                            <th>Descrição do produto</th>
                                            <th>Fornecedor <i class="fa-solid fa-eye-slash"></i></th>
                                            <th><span class="text-info">Custo unit.</span> (R$)
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </th>
                                            <th>MSC (%)
                                                <i class="fa-solid fa-eye-slash"></i>
                                            </th>
                                            <th>Prazo (dias úteis)</th>
                                            <th><span class="text-success">Preço unit.</span> (R$)</th>
                                            <th>QTD.</th>
                                            <th>Subtotais (R$)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($budgetItems as $budgetItem)
                                            @if ($budgetItem->price > 0)
                                                <tr class="align-middle text-center">
                                                    <td>
                                                        <input class="form-check-input available" type="checkbox"
                                                            value="{{ $budgetItem->id }}"
                                                            name="selectedBudgetItemsIds[]">
                                                    </td>
                                                    <td>{{ $budgetItem->description }}</td>
                                                    <td>
                                                        {{ $budgetItem->supplier->name }}
                                                        @if ($budgetItem->supplier_reference)
                                                            <br>{{ $budgetItem->supplier_reference }}
                                                        @endif
                                                    </td>
                                                    <td>{{ number_format($budgetItem->cost, 2, ',', '.') }}</td>
                                                    @php
                                                        $msc = 0;
                                                        $cost = $budgetItem->cost;

                                                        if ($cost != 0) {
                                                            $msc = (($budgetItem->price - $cost) / $cost) * 100;
                                                        }
                                                    @endphp
                                                    <td>{{ number_format($msc, 2) }}%</td>
                                                    <td>{{ $budgetItem->deadline }}</td>
                                                    <td>{{ number_format($budgetItem->price, 2, ',', '.') }}</td>
                                                    <td>{{ $budgetItem->quantity }}</td>
                                                    <td>
                                                        <span class="fw-bold text-info">C</span>
                                                        {{ number_format($budgetItem->cost * $budgetItem->quantity, 2, ',', '.') }}<br>
                                                        <span class="fw-bold text-success">P</span>
                                                        {{ number_format($budgetItem->price * $budgetItem->quantity, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="align-middle text-center">
                                                    <td>
                                                        <input class="form-check-input" type="checkbox" value=""
                                                            name="selectedBudgetItemsIds[]" disabled>
                                                    </td>
                                                    <td>{{ $budgetItem->description }}</td>
                                                    <td>
                                                        <span class="text-secondary fw-bold">NÃO COTADO</span>
                                                    </td>
                                                    <td><span class="text-secondary fw-bold">NÃO COTADO</span></td>
                                                    <td><span class="text-secondary fw-bold">X</span></td>
                                                    <td><span class="text-secondary fw-bold">X</span></td>
                                                    <td><span class="text-secondary fw-bold">NÃO COTADO</span></td>
                                                    <td>{{ $budgetItem->quantity }}</td>
                                                    <td>
                                                        <span class="text-secondary fw-bold">X</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                <input type="hidden" id="budget_id" name="budget_id" value="{{ $budget->id }}">
                                <button title="Selecione os produtos antes de gerar o relatório para pedido"
                                    class="btn btn-light text-primary" type="submit">
                                    <i class="fa-regular fa-file-pdf"></i>
                                    Gerar relatório PDF de peça(s)
                                    selecionada(s)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const button = document.querySelector('.btn-outline-info');
            button.addEventListener('click', function() {
                const checkboxes = document.querySelectorAll('.available');
                let allChecked = true;

                checkboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        allChecked = false;
                    }
                });

                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = !allChecked;
                });
            });
        });
    </script>
@endpush
