@include('partial/header')

<head>
    <title>Sessão Expirada - Mimoquices</title>
</head>

<main>
<div class="auth-container">
    <div class="auth-header">
        <h1 style="font-size: 4rem; margin-bottom: 0.5rem;">⏳ 419</h1>
        <h2>Página Expirada</h2>
        <p>Passou demasiado tempo desde a tua última ação.</p>
    </div>

    <div class="auth-form" style="text-align: center; padding: 3rem 2rem;">
        <div style="font-size: 5rem; margin-bottom: 1.5rem;">☕</div>
        <p style="color: #666; margin-bottom: 2rem;">
            Por motivos de segurança, a tua sessão expirou. Basta clicares no botão abaixo para atualizar e continuar.
        </p>

        <a href="{{ url()->previous() }}" class="btn-submit" style="display: block; text-decoration: none;">
            Atualizar e Voltar
        </a>
    </div>

    <div class="auth-footer">
        <p>Ficaste sem tempo?</p>
        <a href="{{ route('login') }}">Inicia sessão novamente →</a>
    </div>
</div>
</main>

@include('partial/footer')
</body>
</html>