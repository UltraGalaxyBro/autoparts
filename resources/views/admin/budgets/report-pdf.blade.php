<!DOCTYPE html>
<html>

<head>
    <title>Produtos da cotação de ID {{ str_pad($budget->id, 4, '0', STR_PAD_LEFT) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        img {
            padding: 10px;
            position: relative;
            bottom: 20px;
        }

        * {
            box-sizing: border-box;
        }

        .container {
            margin-bottom: -110px;
            padding: -95px;
        }

        .container1 {
            font-size: 10px;
            border: solid #ec0000 2px;

        }

        .titulo {
            margin-left: 280px;
            position: relative;
            top: -100px;
        }

        .data {
            position: relative;
            top: -155px;
            margin-left: 560px;
            font-size: 14px;
        }

        .nome {
            margin-left: 10px;
        }

        .endereco {
            margin-left: 10px;
        }

        .observacao {
            font-size: 10px;
            border: dotted black 2px;
            padding: 5px;
        }

        .titulo-prod {
            margin-left: 240px;

        }

        .titulo-prod1 {
            margin-left: 240px;
        }

        .info-geral {
            font-size: 10px;
            border: solid black 2px;

        }

        .campos-info {
            margin-left: 10px;
        }

        .obs {
            font-size: 10px;
        }

        .infos {
            border-collapse: separate;
            border-spacing: 5px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table td,
        .table th {
            padding: 10px 12px;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 7px;
        }

        .table th {
            background-color: #ec0000;
            color: #ffffff;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .null-quotation {
            font-size: 9px;
            color: gray;
        }
    </style>
</head>

<header>
    <div class="container">
        <div class="logo">
            <img src="{{ public_path('img/logo-and-name.png') }}" alt="Logo e nome da empresa" width="235"
                height="75">
        </div>
        <div class="titulo">
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RELATÓRIO<br>DE ITENS SELECIONADOS</h5>
        </div>
        <div class="data">
            <strong>
                Itens da cotação<br>
                de ID {{ str_pad($budget->id, 4, '0', STR_PAD_LEFT) }}
            </strong>
        </div>
    </div>
    <div class="container1" style="padding: 5px;">
        <table class="infos">
            <tr>
                <td style="padding-right: 15px"><strong>Vendedor(a):</strong></td>
                <td>{{ $budget->user->name }}</td>
            </tr>
            <tr>
                <td style="padding-right: 15px"><strong>Cliente:</strong></td>
                <td>
                    {{ $budget->customer->user->name }}
                    @if ($budget->customer->type_buyer == 'PJ')
                        ({{ $budget->customer->company }} {{ $budget->customer->cnpj }})
                    @endif
                </td>
            </tr>
        </table>
    </div>

</header>

<main>
    <h5 class="titulo-prod">SOBRE PRODUTOS SELECIONADOS</h5>
    <table class="table">
        <thead>
            <tr>
                <th style="font-size: 9px;">Descrição do produto</th>
                <th style="font-size: 9px;">Fornecedor</th>
                <th style="font-size: 9px;">
                    Custo unit. (R$)
                </th>
                <th style="font-size: 9px;">
                    MSC (%)
                </th>
                <th style="font-size: 9px;">Prazo (dias úteis)</th>
                <th style="font-size: 9px;">Preço unit. (R$)</th>
                <th style="font-size: 9px;">QTD.</th>
                <th style="font-size: 9px;">Subtotais (R$)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total_cost_products = 0;
                $total_price_products = 0;
            @endphp
            @foreach ($budgetItems as $budgetItem)
                <tr>
                    <td style="font-size: 12px;">{{ $budgetItem->description }}</td>
                    <td style="font-size: 12px;">
                        {{ $budgetItem->supplier->name }}
                        @if ($budgetItem->supplier_reference)
                            <br>{{ $budgetItem->supplier_reference }}
                        @endif
                    </td>
                    <td style="font-size: 12px;">{{ number_format($budgetItem->cost, 2, ',', '.') }}</td>
                    @php
                        $msc = 0;
                        $cost = $budgetItem->cost;

                        if ($cost != 0) {
                            $msc = (($budgetItem->price - $cost) / $cost) * 100;
                        }
                    @endphp
                    <td style="font-size: 12px;">{{ number_format($msc, 2) }}%</td>
                    <td style="font-size: 12px;">{{ $budgetItem->deadline }}</td>
                    <td style="font-size: 12px;">{{ number_format($budgetItem->price, 2, ',', '.') }}</td>
                    <td style="font-size: 12px;">{{ $budgetItem->quantity }}</td>
                    <td style="font-size: 12px;">
                        <strong>C</strong>
                        {{ number_format($budgetItem->cost * $budgetItem->quantity, 2, ',', '.') }}<br>
                        <strong>P</strong>
                        {{ number_format($budgetItem->price * $budgetItem->quantity, 2, ',', '.') }}
                    </td>
                </tr>
                @php
                    $total_cost_products += $budgetItem->cost * $budgetItem->quantity;
                    $total_price_products += $budgetItem->price * $budgetItem->quantity;
                @endphp
            @endforeach
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th style="font-size: 12px;"><strong>Total custo produtos</strong><br>
                    <strong>
                        R$ {{ number_format($total_cost_products, 2, ',', '.') }}
                    </strong>
                </th>
            
                @php
                    $difference_percent = (($total_price_products - $total_cost_products) / $total_cost_products) * 100;
                @endphp
                <th style="font-size: 12px;"><strong>MSC Geral</strong><br>
                    <strong>
                       aproximadamente {{ number_format($difference_percent, 2, ',', '.') }} %
                    </strong>
                </th>
                <th style="font-size: 12px;"><strong>Total preço produtos</strong><br>
                    <strong>
                        R$ {{ number_format($total_price_products, 2, ',', '.') }}
                    </strong>
                </th>
            </tr>
        </thead>
    </table>
</main>

<footer>
    <div>
        <p class="observacao">
            <strong>Informações Complementares mostradas ao cliente:</strong>
            <br><br>
            @if ($budget->chassis_number)
                Nº CHASSI: {{ $budget->chassis_number }}<br>
            @endif
            @if ($budget->observation)
                {{ $budget->observation }}
            @endif
        </p>
    </div>
</footer>

</body>

</html>
