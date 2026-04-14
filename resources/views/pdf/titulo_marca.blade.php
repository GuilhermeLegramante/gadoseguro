<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 40px;
            border: 1px solid #000;
            height: 90%;
            position: relative;
        }

        /* Brasão de fundo (marca d'água) */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            width: 400px;
            z-index: -1;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .titulo {
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin-top: 30px;
        }

        /* Box da Marca Desenhada */
        .canvas-box {
            border: 2px solid #000;
            width: 250px;
            height: 180px;
            margin: 30px auto;
            text-align: center;
        }

        .canvas-box img {
            max-width: 100%;
            max-height: 100%;
        }

        .texto-legal {
            text-align: justify;
            margin: 40px;
            line-height: 1.6;
            font-size: 16px;
            border: 1px solid #ccc;
            padding: 20px;
        }

        .footer {
            position: absolute;
            bottom: 80px;
            width: 100%;
            text-align: center;
        }

        .assinatura {
            border-top: 1px solid #000;
            width: 300px;
            margin: 0 auto;
            padding-top: 5px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <div class="container">
        <img src="{{ public_path('images/brasao_fundo.png') }}" class="watermark">

        <div class="header">
            <img src="{{ public_path('images/brasao.png') }}" style="width: 60px; float: left;">
            <div style="display: inline-block;">
                <strong>Título de Registro de Marca</strong><br>
                SECRETARIA DA FAZENDA E PLANEJAMENTO<br>
                {{ $marca->municipio->nome }} - {{ $marca->municipio->uf }}
            </div>
            <div style="float: right;">
                <img src="data:image/png;base64, {!! base64_encode(
                    QrCode::format('svg')->size(80)->generate(route('marcas.verificar-qrcode', $marca->id)),
                ) !!} ">
            </div>
        </div>

        <div class="titulo">
            TÍTULO DE REGISTRO DE MARCA<br>
            Nº {{ $marca->numero }} / {{ $marca->ano }}
        </div>

        <div class="canvas-box">
            <img src="{{ $marca->desenho_base64 }}">
        </div>

        <div class="texto-legal">
            Fica registrada a referida marca, a qual identificará os animais de propriedade de
            <strong>{{ $marca->produtor->nome }}</strong>, CPF/CNPJ nº {{ $marca->produtor->cpf_cnpj }},
            nas localidades deste município, pelo que lhe fornecemos o presente
            <strong>TÍTULO</strong> para os devidos fins.
        </div>

        <div class="footer">
            <p>{{ $marca->municipio->nome }} - {{ $marca->municipio->uf }},
                {{ now()->translatedFormat('d \d\e F \d\e Y') }}</p>
            <br><br>
            <div class="assinatura">Responsável pelo Setor</div>
        </div>
    </div>

</body>

</html>
