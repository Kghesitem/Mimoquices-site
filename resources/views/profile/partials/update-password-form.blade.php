<section>

    <header style="margin-bottom: 1.5rem;">
        <h2 class="text-lg font-medium">
            Alterar Palavra-passe
        </h2>

        <p class="helper-text">
            Utilize uma palavra-passe longa e difícil de adivinhar para manter a sua conta segura.
        </p>
    </header>

    {{-- ERROS --}}
    @if ($errors->updatePassword->any())
        <div class="error-container">
            <strong>Ocorreu um erro:</strong>
            <ul>
                @foreach ($errors->updatePassword->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        {{-- PALAVRA-PASSE ATUAL --}}
        <div class="form-group">
            <label for="current_password" class="form-label">
                Palavra-passe atual
            </label>

            <input
                id="current_password"
                name="current_password"
                type="password"
                class="form-input"
                autocomplete="current-password"
                required
            >
            {{-- Indicador de força (opcional - já tens CSS) --}}
            <div class="password-strength">
                <div class="password-strength-bar"></div>
            </div>
        </div>

        {{-- NOVA PALAVRA-PASSE --}}
        <div class="form-group">
            <label for="password" class="form-label">
                Nova palavra-passe
            </label>

            <input
                id="password"
                name="password"
                type="password"
                class="form-input"
                autocomplete="new-password"
                required
            >

            
            <span class="password-strength-text"></span>
        </div>

        {{-- CONFIRMAÇÃO --}}
        <div class="form-group">
            <label for="password_confirmation" class="form-label">
                Confirmar nova palavra-passe
            </label>

            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                class="form-input"
                autocomplete="new-password"
                required
            >
        </div>

        {{-- SUCESSO --}}
        @if (session('status') === 'password-updated')
            <div class="alert-sucesso-personalizacao">
                Palavra-passe atualizada com sucesso.
            </div>
        @endif

        {{-- BOTÃO --}}
        <button type="submit" class="btn-submit">
            Guardar alterações
        </button>

    </form>

</section>
