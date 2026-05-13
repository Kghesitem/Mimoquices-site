@include('partial/header')
<head>
    <title>Página Não Encontrada - Mimoquices</title>
</head>

<main>
<div class="auth-container">
    <div class="auth-header">
        <h1 style="font-size: 4rem; margin-bottom: 0.5rem;"><x-heroicon-s-magnifying-glass style="width: 4.5rem; height: 4.5rem;"/> 404</h1>
        <h2>Página Não Encontrada</h2>
        <p class="mt-4">Ups! Parece que a página que procura decidiu tirar uma sesta ou foi movida para outro lugar.</p>
    </div>

    <div class="auth-form" style="text-align: center; padding: 3rem 2rem;">
        <div style="font-size: 5rem; margin-bottom: 1.5rem;">
        </div>
        <h5 style="color: #666; margin-bottom: 2rem;">
            Não se preocupe, pode voltar para a página inicial e continuar a explorar as nossas mimoquices.
        </h5>

        <a href="{{ url('/') }}" class="btn-submit" style="display: block; text-decoration: none; text-align: center;">
            Voltar para a Página Inicial
        </a>
    </div>

    <div class="auth-footer">
        <p>Precisa de ajuda para encontrar algo?</p>
        <a class="social-links" href="https://www.instagram.com/mimoquices.mv/" target="_blank">Link de contacto</a>
    </div>
</div>
</main>

@include('partial/footer')

</body>
</html>