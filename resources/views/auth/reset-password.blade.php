@include('partial/header')

<main>
    <div class="auth-container">
        <!-- HEADER -->
        <div class="auth-header">
            <h1>🔐 Repôr Palavra‑passe</h1>
            <p>Introduza a nova palavra‑passe para a sua conta</p>
        </div>

        <div style="padding: 1.1rem 1.5rem 0;">
            <!-- Session status -->
            @if (session('status'))
                <div class="status-success">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Erros gerais -->
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

        <!-- FORM -->
        <form method="POST" action="{{ route('password.store') }}" class="auth-form" novalidate>
            @csrf

            <!-- Token oculto vindo da rota -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="form-group">
                <label for="email" class="form-label">📧 Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                    value="{{ old('email', $request->email) }}"
                    placeholder="seu.email@example.com"
                    required
                    autofocus
                    autocomplete="username"
                />
                @error('email')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">🔒 Palavra‑passe</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                />
                @error('password')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">🔒 Confirmar Palavra‑passe</label>
                <input
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                />
                @error('password_confirmation')
                    <span class="field-error">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 0.75rem;">
                <button type="submit" class="btn-submit" onclick="this.disabled=true; this.form.submit();">
                    Repôr Palavra‑passe
                </button>
            </div>
        </form>

        <!-- FOOTER -->
        <div class="auth-footer">
            <p>Lembraste da palavra‑passe?</p>
            <a href="{{ route('login') }}">Voltar ao Início de Sessão →</a>
        </div>
    </div>
</main>

@include('partial/footer')