@include('partial/header')
<head>
    <title>Erro Inesperado - Mimoquices</title>
</head>

<main>
<div class="auth-container">
    <div class="auth-header">
        <h1 style="font-size: 4rem; margin-bottom: 0.5rem;"><x-heroicon-c-cog-6-tooth style="width: 4.5rem; height: 4.5rem;"/> 500</h1>
        <h2>Algo correu mal</h2>
        <p>O nosso servidor tropeçou em alguma mimoquice.</p>
    </div>

    <div class="auth-form" style="text-align: center; padding: 3rem 2rem;">
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