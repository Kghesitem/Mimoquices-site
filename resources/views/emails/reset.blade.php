<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Estilos base para garantir compatibilidade com e-mail */
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8f9fa;
            padding: 40px 0;
        }
        .card {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        /* Cabeçalho com a cor rosa/acastanhada da imagem */
        .header {
            background-color: #c68a7f;
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 600;
        }
        .header .emoji {
            font-size: 40px;
            display: block;
            margin-bottom: 10px;
        }
        /* Conteúdo do e-mail */
        .content {
            padding: 40px 30px;
            text-align: center;
            color: #444444;
            line-height: 1.6;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 25px;
        }
        /* Botão estilizado */
        .btn {
            display: inline-block;
            background-color: #c68a7f;
            color: #ffffff !important;
            padding: 14px 30px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        /* Rodapé */
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #888888;
        }
        .footer strong {
            color: #c68a7f;
        }
        /* Link de segurança para quebra de linha */
        .subcopy {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            font-size: 12px;
            color: #999999;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <span class="emoji">🔐</span>
                <h1>Recuperar Palavra-passe</h1>
            </div>

            <div class="content">
                <p>Esqueceu a sua Palavra-passe? Não há problema. Basta clicar no botão abaixo para escolher uma nova palavra-passe.</p>
                
                <a href="{{ $url }}" class="btn">Repor palavra-passe</a>

                <p style="margin-top: 30px; font-size: 14px; color: #777;">
                    Se não solicitou esta alteração, ignore este e-mail em segurança.
                </p>

                <div class="subcopy">
                    Se tiver problemas ao clicar no botão, copie e cole o link abaixo no seu navegador: <br>
                    <a href="{{ $url }}" style="color: #c68a7f;">{{ $url }}</a>
                </div>
            </div>
        </div>

        <div class="footer">
            Atentamente,<br>
            <strong>Equipa Mimoquices</strong>
        </div>
    </div>
</body>
</html>