@include('partial/header')

    <main>
    <div class="auth-container">
        <!-- header -->
        <div class="auth-header">
            <h1>🔐 Recuperar Palavra‑passe</h1>
        </div>

        <div style="padding: 1.1rem 1.5rem 0;">
            <!-- explicação (texto pedido) -->
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Esqueceu sua senha? Não há problema. 
                    Basta nos informar seu endereço de e-mail e 
                    nós enviaremos um link de redefinição
                    de senha que permitirá que você escolha uma nova.') }}
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Erros genéricos -->
            @if ($errors->any())
                <div class="error-container">
                    <strong>⚠️ Foram encontrados erros:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- form -->
        <form method="POST" action="{{ route('password.email') }}" class="auth-form" style="padding-top:0;">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input id="email"
                       type="email"
                       name="email"
                       class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                       value="{{ old('email') }}"
                       placeholder="seu.email@example.com"
                       required
                       autofocus
                       autocomplete="email" />
            </div>

            <div style="margin-top: 0.75rem;">
                <button type="submit" class="btn-submit" onclick="this.disabled=true; this.form.submit();">
                    Repor palavra-passe
                </button>
            </div>
        </form>
</main>

@include('partial/footer')

