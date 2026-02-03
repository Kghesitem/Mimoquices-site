<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sessão - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial/header')

<main>
<div class="auth-container">
    <!-- CABEÇALHO DO FORMULÁRIO -->
    <div class="auth-header">
        <h1>🔐 Iniciar Sessão</h1>
        <p>Bem-vindo de volta! Inicie sessão para continuar</p>
    </div>

    <!-- ERROS (se existirem) -->
    @if ($errors->any())
    <div style="padding: 0 2rem; padding-top: 1.5rem;">
        <div class="error-container">
            <strong>⚠️ Erro ao iniciar sessão:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- FORMULÁRIO DE LOGIN -->
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">📧 Endereço de Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}"
                placeholder="seu.email@example.com"
                required
                autofocus
                autocomplete="email"
            />
            @error('email')
            <span class="field-error">Email inválido ou não registado</span>
            @enderror
        </div>

        <!-- Palavra-passe -->
        <div class="form-group">
            <label for="password" class="form-label">🔒 Palavra-passe</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            />
            @error('password')
            <span class="field-error">Palavra-passe incorreta</span>
            @enderror
        </div>

        <!-- Ações -->
        <div class="form-actions">
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-password-link">
                Esqueceu a palavra-passe?
            </a>
            @endif
        </div>

        <!-- Botão Submit -->
        <button type="submit" class="btn-submit"
        onclick="this.disabled=true; this.form.submit();">
            Iniciar Sessão
        </button>
    </form>

    <!-- RODAPÉ - LINK PARA REGISTO -->
    <div class="auth-footer">
        <p>Ainda não tem conta?</p>
        <a href="{{ route('register') }}">Crie uma conta agora →</a>
    </div>
</div>
</main>

@include('partial/footer')

</body>
</html>

