<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etiquetagem</title>
    <style>
        @page {
            size: auto;
            margin: 0;
        }

        /*ESTILOS DA ETIQUETA TAMANHO P ------ INÍCIO*/
        .label-P {
            width: 46%;
            height: 21%;
            border: 1px black dashed;
            padding: 12px;
            margin: 2px;
            background-color: #fff;
            float: left;
        }

        .false-label-P {
            width: 46%;
            height: 21%;
            padding: 12px;
            margin: 2px;
            background-color: #fff;
            float: left;
        }

        .row-P {
            width: 100%;
        }

        .row-P td {
            padding: 5px;
        }

        .text-row-P-1 {
            font-size: 30px;
            font-weight: bold;
        }

        .text-row-P-2 {
            font-size: 20px;
            font-weight: bold;
            word-wrap: break-word;
        }

        .text-row-P-2-alt {
            font-size: 28px;
            font-weight: bold;
            word-wrap: break-word;
        }

        /*ESTILOS DA ETIQUETA TAMANHO P ------ FIM*/

        /*ESTILOS DA ETIQUETA TAMANHO M ------ INÍCIO*/
        .label-M {
            width: 96%;
            height: 21%;
            border: 1px black dashed;
            padding: 12px;
            margin: 2px;
            background-color: #fff;
        }

        table.row-M {
            width: 100%;
        }

        table.row-M td {
            padding: 5px;
        }

        .text-row-M-1 {
            font-size: 60px;
            font-weight: bold;
        }

        .text-row-M-2 {
            font-size: 25px;
            font-weight: bold;
            word-wrap: break-word;
        }

        .text-row-M-2-alt {
            font-size: 32px;
            font-weight: bold;
            word-wrap: break-word;
        }

        /*ESTILOS DA ETIQUETA TAMANHO M ------ FIM*/

        /*ESTILOS DA ETIQUETA TAMANHO G ------ INÍCIO*/
        .label-G {
            width: 96%;
            height: 42%;
            border: 1px black dashed;
            padding: 12px;
            margin: 2px;
            background-color: #fff;
        }

        table.row-G {
            width: 100%;
        }

        table.row-G td {
            padding: 5px;
        }

        .text-row-G-1 {
            font-size: 60px;
            font-weight: bold;
        }

        .text-row-G-2 {
            font-size: 60px;
            font-weight: bold;
            word-wrap: break-word;
        }

        .text-row-G-2-alt {
            font-size: 75px;
            font-weight: bold;
            word-wrap: break-word;
        }

        /*ESTILOS DA ETIQUETA TAMANHO G ------ FIM*/

        /*ESTILOS DA ETIQUETA TAMANHO E ------ INÍCIO*/
        .label-E {
            width: 200mm;
            /* Largura da folha A4 */
            height: 285mm;
            /* Altura da folha A4 */
            padding-left: 50px;
            padding-top: 10px;
            padding-bottom: 10px;
            padding-left: 10px;
            border: 1px black dashed;
            background-color: #fff;
        }

        /* Estilo para a tabela */
        .table-E {
            width: 100%;
        }

        /* Estilo para as células da tabela */
        .table-E td {
            padding: 5px;
        }

        /* Estilos para o texto */
        .text-row-E-1 {
            font-size: 70px;
            font-weight: bold;
            word-wrap: break-word;

        }

        .text-row-E-1-alt {
            font-size: 78px;
            font-weight: bold;
            word-wrap: break-word;

        }

        /*ESTILOS DA ETIQUETA TAMANHO E ------ FIM*/
        .clear-after {
            clear: both;
        }

        .page-break {
            page-break-after: always;
        }

        .space {
            margin-top: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    @php
        $pageSpaces = 8;
    @endphp

    @foreach ($request['labels'] as $lot)
        @php
            $count = 0;
        @endphp
        @for ($i = 0; $i < $lot['quantity']; $i++)
            @if ($pageSpaces <= 0)
                @php
                    $pageSpaces = 8;
                    $count = 0;
                @endphp
            @endif
            @if ($lot['size'] === 'P')
                @if ($pageSpaces > 0)
                    <div class="label-P">
                        <table class="row-P">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="50px"
                                            height="50px">
                                    </td>
                                    <td class="text-row-P-1">
                                        {{ $lot['nf'] }}
                                    </td>
                                    <td class="text-row-P-1">
                                        {{ $lot['volumes'] }} VOL.
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <img src="{{ public_path('img/qrcode_contato.png') }}"
                            alt="QR Code para levar a página com informações de contato" width="50px" height="50px">
                        @if ($lot['danger'])
                            <table class="row-P">
                                <thead>
                                    <tr>
                                        <td class="text-row-P-2">
                                            {{ $lot['receiver'] }},
                                        </td>
                                        <td class="text-row-P-2">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <br>
                            <img src="{{ public_path('img/danger-label-P.png') }}"
                                alt="Etiqueta de fragilidade tamanho P" width="100%" height="20%">
                        @else
                            <p class="text-row-P-2-alt">{{ $lot['receiver'] }}</p>
                            <p class="text-row-P-2-alt">{{ $lot['place'] }}</p>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 1;
                        $count++;
                        if ($count % 2 === 0) {
                            echo '<div class="clear-after"></div>';
                        }
                    @endphp
                @else
                    <div class="page-break"></div>
                    @php
                        $pageSpaces = 8;
                    @endphp
                    <div class="label-P">
                        <table class="row-P">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="50px"
                                            height="50px">
                                    </td>
                                    <td class="text-row-P-1">
                                        {{ $lot['nf'] }}
                                    </td>
                                    <td class="text-row-P-1">
                                        {{ $lot['volumes'] }} VOL.
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <img src="{{ public_path('img/qrcode_contato.png') }}"
                            alt="QR Code para levar a página com informações de contato" width="50px" height="50px">
                        @if ($lot['danger'])
                            <table class="row-P">
                                <thead>
                                    <tr>
                                        <td class="text-row-P-2">
                                            {{ $lot['receiver'] }},
                                        </td>
                                        <td class="text-row-P-2">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <br>
                            <img src="{{ public_path('img/danger-label-P.png') }}"
                                alt="Etiqueta de fragilidade tamanho P" width="100%" height="20%">
                        @else
                            <p class="text-row-P-2-alt">{{ $lot['receiver'] }}</p>
                            <p class="text-row-P-2-alt">{{ $lot['place'] }}</p>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 1;
                        $count++;
                        if ($count % 2 === 0) {
                            echo '<div class="clear-after"></div>';
                        }
                    @endphp
                @endif
            @elseif ($lot['size'] === 'M')
                <div class="clear-after"></div>
                @if ($pageSpaces > 1)
                    <div class="label-M">
                        <table class="row-M">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="75px"
                                            height="75px">
                                    </td>
                                    <td class="text-row-M-1">
                                        {{ $lot['nf'] }},
                                    </td>
                                    <td class="text-row-M-1">
                                        {{ $lot['volumes'] }}
                                        VOL.
                                    </td>
                                    <td>
                                        <img src="{{ public_path('img/qrcode_contato.png') }}"
                                            alt="QR Code para levar a página com informações de contato" width="65px"
                                            height="65px">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($lot['danger'])
                            <br>
                            <table class="row-M">
                                <thead>
                                    <tr>
                                        <td class="text-row-M-2">
                                            {{ $lot['receiver'] }}
                                        </td>
                                        <td class="text-row-M-2">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <img src="{{ public_path('img/danger-label-M.png') }}"
                                alt="Etiqueta de fragilidade tamanho M" width="100%" height="15%">
                        @else
                            <p class="text-row-M-2-alt">{{ $lot['receiver'] }}</p>
                            <p class="text-row-M-2-alt">{{ $lot['place'] }}</p>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 2;

                    @endphp
                @else
                    <div class="page-break"></div>
                    @php
                        $pageSpaces = 8;
                    @endphp
                    <div class="label-M">
                        <table class="row-M">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="75px"
                                            height="75px">
                                    </td>
                                    <td class="text-row-M-1">
                                        {{ $lot['nf'] }},
                                    </td>
                                    <td class="text-row-M-1">
                                        {{ $lot['volumes'] }}
                                        VOL.
                                    </td>
                                    <td>
                                        <img src="{{ public_path('img/qrcode_contato.png') }}"
                                            alt="QR Code para levar a página com informações de contato" width="65px"
                                            height="65px">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($lot['danger'])
                            <br>
                            <table class="row-M">
                                <thead>
                                    <tr>
                                        <td class="text-row-M-2">
                                            {{ $lot['receiver'] }}
                                        </td>
                                        <td class="text-row-M-2">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <img src="{{ public_path('img/danger-label-M.png') }}"
                                alt="Etiqueta de fragilidade tamanho M" width="100%" height="15%">
                        @else
                            <p class="text-row-M-2-alt">{{ $lot['receiver'] }}</p>
                            <p class="text-row-M-2-alt">{{ $lot['place'] }}</p>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 2;
                    @endphp
                @endif
            @elseif ($lot['size'] === 'G')
                <div class="clear-after"></div>
                @if ($pageSpaces > 3)
                    <div class="label-G">
                        <table class="row-G">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="100px"
                                            height="100px">
                                    </td>
                                    <td class="text-row-G-1">
                                        {{ $lot['nf'] }},
                                    </td>
                                    <td class="text-row-G-1">
                                        {{ $lot['volumes'] }}, VOL.
                                    </td>
                                    <td>
                                        <img src="{{ public_path('img/qrcode_contato.png') }}"
                                            alt="QR Code para levar a página com informações de contato"
                                            width="90px" height="90px">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($lot['danger'])
                            <br>
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2">
                                            {{ $lot['receiver'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <img src="{{ public_path('img/danger-label-G.png') }}"
                                alt="Etiqueta de fragilidade tamanho G" width="100%" height="30%">
                        @else
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2-alt">
                                            {{ $lot['receiver'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <div class="space"></div>
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2-alt">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 4;

                    @endphp
                @else
                    <div class="clear-after"></div>
                    <div class="page-break"></div>
                    @php
                        $pageSpaces = 8;
                    @endphp
                    <div class="label-G">
                        <table class="row-G">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="100px"
                                            height="100px">
                                    </td>
                                    <td class="text-row-G-1">
                                        {{ $lot['nf'] }},
                                    </td>
                                    <td class="text-row-G-1">
                                        {{ $lot['volumes'] }}, VOL.
                                    </td>
                                    <td>
                                        <img src="{{ public_path('img/qrcode_contato.png') }}"
                                            alt="QR Code para levar a página com informações de contato"
                                            width="90px" height="90px">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($lot['danger'])
                            <br>
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2">
                                            {{ $lot['receiver'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <br>
                            <img src="{{ public_path('img/danger-label-G.png') }}"
                                alt="Etiqueta de fragilidade tamanho G" width="100%" height="30%">
                        @else
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2-alt">
                                            {{ $lot['receiver'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                            <div class="space"></div>
                            <table class="row-G">
                                <thead>
                                    <tr>
                                        <td class="text-row-G-2-alt">
                                            {{ $lot['place'] }}
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 4;
                    @endphp
                @endif
            @else
                @if ($pageSpaces == 8)
                    <div class="label-E">
                        <table class="table-E">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="200px"
                                            height="200px">
                                    </td>
                                    <td>
                                        <img src="{{ public_path('img/qrcode_contato.png') }}" width="180px"
                                            height="180px">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($lot['danger'])
                            <p class="text-row-E-1">
                                {{ $lot['nf'] }}<br>
                                {{ $lot['volumes'] }} VOL.<br>
                                {{ $lot['receiver'] }}<br>
                                {{ $lot['place'] }}
                            </p>
                            <br>
                            <img src="{{ public_path('img/danger-label-E.png') }}"
                                alt="Etiqueta de fragilidade tamanho E" width="90%" height="28%">
                        @else
                            <div class="space"></div>
                            <br>
                            <p class="text-row-E-1-alt">
                                {{ $lot['nf'] }}<br>
                                {{ $lot['volumes'] }} VOL.<br>
                                {{ $lot['receiver'] }}<br>
                                {{ $lot['place'] }}
                            </p>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 8;
                    @endphp
                @else
                    <div class="page-break"></div>
                    @php
                        $pageSpaces = 8;
                    @endphp
                    <div class="label-E">
                        <table class="table-E">
                            <thead>
                                <tr>
                                    <td>
                                        <img src="{{ public_path('img/logo.png') }}" alt="Logo" width="200px"
                                            height="200px">
                                    </td>
                                    <td>
                                        <img src="{{ public_path('img/qrcode_contato.png') }}" width="180px"
                                            height="180px">
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        @if ($lot['danger'])
                            <p class="text-row-E-1">
                                {{ $lot['nf'] }}<br>
                                {{ $lot['volumes'] }} VOL.<br>
                                {{ $lot['receiver'] }}<br>
                                {{ $lot['place'] }}
                            </p>
                            <br>
                            <img src="{{ public_path('img/danger-label-E.png') }}"
                                alt="Etiqueta de fragilidade tamanho E" width="90%" height="28%">
                        @else
                            <div class="space"></div>
                            <br>
                            <p class="text-row-E-1-alt">
                                {{ $lot['nf'] }}<br>
                                {{ $lot['volumes'] }} VOL.<br>
                                {{ $lot['receiver'] }}<br>
                                {{ $lot['place'] }}
                            </p>
                        @endif
                    </div>
                    @php
                        $pageSpaces -= 8;
                    @endphp
                @endif
            @endif
        @endfor
    @endforeach
</body>

</html>
