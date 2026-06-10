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
    {{-- CABEÇALHO DO FORMULÁRIO --}}
    <div class="auth-header">
        <h1><x-heroicon-s-user style="width: 2rem; height: 2rem;"/> Iniciar Sessão</h1>
        <p>Bem-vindo de volta! Inicie sessão para continuar</p>
    </div>

    {{-- ERROS (se existirem) --}}
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Erro!',

                html: "{!! implode('<br>', array_map('e', $errors->all())) !!}",
                icon: 'error',
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    {{-- FORMULÁRIO DE LOGIN --}}
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <label for="email" class="form-label"><x-heroicon-c-envelope style="color: var(--main_color); width: 1.25rem; height: 1.25rem;"/> Endereço de Email</label>
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
        </div>

        {{-- Palavra-passe --}}
        <div class="form-group">
            <label for="password" class="form-label"><x-heroicon-s-lock-closed style="color: var(--main_color); width: 1.25rem; height: 1.25rem;"/> Palavra-passe</label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="current-password"
            />
        </div>

        {{-- Ações --}}
        <div class="form-actions">
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-password-link">
                Esqueceu a palavra-passe?
            </a>
            @endif
        </div>

        {{-- Botão Submit --}}
        <button type="submit" class="btn-submit"
        onclick="this.disabled=true; this.form.submit();">
            Iniciar Sessão
        </button>
    </form>

    {{-- RODAPÉ - LINK PARA REGISTO --}}
    <div class="auth-footer">
        <p>Ainda não tem conta?</p>
        <a href="{{ route('register') }}">Crie uma conta agora →</a>
    </div>
</div>
</main>

@include('partial/footer')

</body>
</html>

