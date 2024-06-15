<!DOCTYPE html>
<html>

<head>
    <title>Cotação de ID {{ str_pad($budget->id, 4, '0', STR_PAD_LEFT) }}</title>
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
            border: solid #0b2a6f 2px;

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
            background-color: #0b2a6f;
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
            <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COTAÇÃO<br>(SEM VALOR FISCAL)</h5>
        </div>
        <div class="data">
            <strong>
                {{ \Carbon\Carbon::parse($budget->created_at)->tz('America/Sao_Paulo')->format('d/m/Y') }}<br>
                ID {{ str_pad($budget->id, 4, '0', STR_PAD_LEFT) }}
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

            <tr>
                <td style="padding-right: 15px"><strong>Tipo frete:</strong></td>
                <td>{{ $budget->freight_type }}</td>
            </tr>
            <tr>
                <td style="padding-right: 15px"><strong>Validade da cotação:</strong></td>
                <td>{{ \Carbon\Carbon::parse($budget->validity)->tz('America/Sao_Paulo')->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding-right: 15px"><strong>Método de pagamento sugerido:</strong></td>
                <td>
                    {{ $budget->payment_method }}
                    @if ($budget->payment_method == 'BOLETO' && $budget->payment_details_bol != null)
                        ({{ $budget->payment_details_bol }} dias)
                    @elseif ($budget->payment_method == 'CARTÃO DE CRÉDITO' && $budget->payment_details_credit != null)
                        ({{ $budget->payment_details_bol }} de parcelas)
                    @else
                        (consulte o vendedor para saber mais sobre)
                    @endif
                </td>
            </tr>
        </table>
    </div>

</header>

<main>
    <h5 class="titulo-prod">SOBRE PRODUTOS REQUISITADOS</h5>
    <table class="table">
        <thead>
            <tr>
                <th style="font-size: 9px;"><strong>Item</strong></th>
                <th style="font-size: 9px;"><strong>Descrição da Peça</strong></th>
                <th style="font-size: 9px;"><strong>Quantidade</strong></th>
                <th style="font-size: 9px;"><strong>Preço unit. (R$)</strong></th>
                <th style="font-size: 9px;"><strong>Subtotal (R$)</strong></th>
                <th style="font-size: 9px;"><strong>Prazo (dias)</strong></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($budgetItems as $key => $item)
                @php
                    $totalProducts = 0;
                    $null_quotation = false;
                    if ($item->price == null || $item->price == 0) {
                        $null_quotation = true;
                    }
                @endphp
                <tr>
                    <td style="font-size: 12px;" data-label="Item" class="fonte-maior">
                        # {{ $key + 1 }}
                    </td>
                    <td style="font-size: 10px;" data-label="Descrição da Peça" class="fonte-menor">
                        {{ $item->description }}
                    </td>
                    <td style="font-size: 12px;" data-label="Quantidade">
                        {{ $item->quantity }}
                    </td>
                    <td style="font-size: 12px;" data-label="Preço unitário">
                        @if ($null_quotation)
                            <span class="null-quotation">NÃO TEM</span>
                        @else
                            {{ number_format($item->price, 2, ',', '.') }}
                        @endif
                    </td>
                    <td style="font-size: 12px;" data-label="Subtotal">
                        @if ($null_quotation)
                            <span class="null-quotation">NÃO TEM</span>
                        @else
                            {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                        @endif
                    </td>
                    <td style="font-size: 12px;" data-label="Prazo">
                        @if ($null_quotation)
                            <span class="null-quotation">X</span>
                        @else
                            {{ $item->deadline }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
                @if ($budget->expenses)
                    <th style="font-size: 12px;"><strong>Despesas</strong><br>
                        R$ {{ number_format($budget->expenses, 2, ',', '.') }}
                    </th>
                @endif
                @if ($budget->freight_type == 'CIF' && $budget->freight_price)
                    <th style="font-size: 12px;"><strong>Valor frete</strong><br>
                        R$ {{ number_format($budget->freight_price, 2, ',', '.') }}
                    </th>
                @endif
                @if ($budget->discount)
                    <th style="font-size: 12px;"><strong>Desconto</strong><br>
                        - R$ {{ number_format($budget->discount, 2, ',', '.') }}
                    </th>
                @endif
                <th style="font-size: 12px;"><strong>Total final</strong><br>
                    <strong>
                        R$ {{ number_format($budget->total_price, 2, ',', '.') }}
                    </strong>
                </th>
            </tr>
        </thead>
    </table>
</main>

<footer>
    <div>
        <p class="observacao">
            <strong>Informações Complementares:</strong>
            <br><br>
            @if ($budget->chassis_number)
                Nº CHASSI: {{ $budget->chassis_number }}<br>
            @endif
            @if ($budget->observation)
                {{ $budget->observation }}
            @endif
        </p>
    </div>

    <div class="obs">
        <strong>Observações:</strong>
        <ul>
            <li>A coluna informando o prazo, que se baseia em dias úteis, corresponde ao tempo máximo necessário para
                a prontidão de
                tal produto ser despachado. Tal prazo do pedido só começará a contar quando houver a O.C.
                (Ordem de Compra);</li>
            <li>Após o pedido ser despachado não é mais responsabilidade da CO2 Peças o prazo que irá levar para chegada
                ao destinatário;</li>
            <li>Os preços das peças apresentadas desta cotação para alguma futura podem variar sem aviso prévio devido à
                oscilação do mercado, portanto se atente a data de validade da cotação que está informada;</li>
            <li>O total final da cotação apresentada pode variar dependendo do método de pagamento optado pelo cliente,
                portanto a garantia de mesmo valor é referente ao método de pagamento sugerido;</li>
            <li>Caso seja de seu interesse emitir a O.C. (Ordem de Compra) referente a esta cotação, enviar a mesma para
                e-mail <strong>{{ $budget->user->email }}</strong> ou <strong>exemplo.repcom@gmail.com</strong>
                informando
                assim a numeração da ID (está abaixo da data).</li>
        </ul>
    </div>
    <p style="font-size: 10px; margin-left: 200px;"><strong><em>Nós, da CO2 Peças, agradecemos a sua preferência e
                compreensão!</em></strong></p>
</footer>

</body>

</html>
