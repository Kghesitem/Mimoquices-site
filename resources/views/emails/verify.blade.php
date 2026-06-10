<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail - Mimoquices</title> {{-- Adicionado para resolver o aviso do SonarQube --}}

    <style>
        body { margin: 0; padding: 0; background-color: #f8f9fa; font-family: sans-serif; }
        .wrapper { width: 100%; background-color: #f8f9fa; padding: 40px 0; }
        .card { max-width: 500px; margin: 0 auto; background-color: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .header { background-color: #c68a7f; padding: 40px 20px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 40px 30px; text-align: center; color: #444; line-height: 1.6; }
        .btn { display: inline-block; background-color: #c68a7f; color: #ffffff !important; padding: 14px 30px; text-decoration: none; border-radius: 12px; font-weight: bold; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 13px; color: #888; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <h1>📧 Verificar E-mail</h1>
            </div>
            <div class="content">
                <p>Bem-vindo à <strong>Mimoquices</strong>! <br> Para começares a utilizar a tua conta, precisamos apenas que confirmes o teu endereço de e-mail.</p>

                <a href="{{ $url }}" class="btn">Confirmar E-mail</a>

                <p style="margin-top: 25px; font-size: 14px;">Se não criaste uma conta, podes ignorar este e-mail.</p>
            </div>
        </div>
        <div class="footer">Atentamente, <br> <strong>Equipa Mimoquices</strong></div>
    </div>
</body>
</html>
