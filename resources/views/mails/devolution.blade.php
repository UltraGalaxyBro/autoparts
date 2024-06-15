<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail solicitação de devolução</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #114c8d;
        }

        p {
            color: #555;
            line-height: 1.6;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }

        .subject {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #114c8d;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #0e3a6d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 style="text-align: center;">E-mail referente a uma solicitação de devolução</h1>
        <div class="message">
            <p><strong>Momento exato em que a solicitação chegou:</strong> {{ now()->format('d/m/Y H:i:s') }}</p>
            <p><strong>Nome do possível cliente:</strong> {{ $data['fromName'] }}</p>
            <p><strong>E-mail do possível cliente:</strong> {{ $data['fromEmail'] }}</p>
            <p><strong>Telefone do possível cliente:</strong> {{ $data['fromTelephone'] }} | <strong>Número de
                    WhatsApp?</strong>
                @if ($data['isWhatsApp'])
                    {{ $data['isWhatsApp'] }}
                @else
                    Não
                @endif
            </p>
            <p class="subject"><strong>Assunto:</strong> {{ $data['subject'] }}</p>
            <p class="subject"><strong>Motivo da devolução:</strong> {{ $data['reason'] }}</p>
            <p class="subject"><strong>Nº da nota relacionada:</strong> {{ $data['nf'] }}</p>
            <p><strong>Produto(s) e o que houve sobre:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
        <p>Se atente que podem haver imagens em anexo a este e-mail.</p>
        <p>Por favor, entre em contato com o solicitante o mais rápido possível assim que tiver uma decisão.</p>
        <p>Obrigado!</p>
    </div>
</body>

</html>
