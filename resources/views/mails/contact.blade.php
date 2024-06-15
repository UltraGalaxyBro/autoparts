<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-mail contato | E-commerce</title>
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
        <div style="text-align: center;">
            <img src="{{ asset('img/logo.svg') }}" width="80px" height="80px" alt="Logo da empresa">
        </div>
        <h1 style="text-align: center;">E-mail de Contato - Ecommerce</h1>
        <div class="message">
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
            <p><strong>Mensagem:</strong></p>
            <p>{{ $data['message'] }}</p>
        </div>
        <p>Por favor, responda a este e-mail o mais rápido possível.</p>
        <p>Obrigado!</p>
    </div>
</body>

</html>
