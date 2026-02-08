<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro Inesperado - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial/header')

<main>
<div class="auth-container">
    <div class="auth-header">
        <h1 style="font-size: 4rem; margin-bottom: 0.5rem;">⚙️ 500</h1>
        <h2>Algo correu mal</h2>
        <p>O nosso servidor tropeçou em alguma mimoquice.</p>
    </div>

    <div class="auth-form" style="text-align: center; padding: 3rem 2rem;">
        <div style="font-size: 5rem; margin-bottom: 1.5rem;">🩹</div>
        <p style="color: #666; margin-bottom: 2rem;">
            Já fomos notificados e estamos a corrigir o problema. Tenta recarregar a página dentro de momentos.
        </p>

        <button onclick="window.location.reload();" class="btn-submit">
            Tentar Novamente
        </button>
    </div>

    <div class="auth-footer">
        <p>O problema persiste?</p>
        <a href="https://www.instagram.com/mimoquices.mv/" target="_blank">Avisar a equipa técnica →</a>
    </div>
</div>
</main>

@include('partial/footer')
</body>
</html>