
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial/header')

<main>
<div class="auth-container">
    <!-- CABEÇALHO DO FORMULÁRIO -->
    <div class="auth-header">
        <h1><x-heroicon-s-user-plus style="width: 2rem; height: 2rem;"/> Criar Conta</h1>
        <p>Junte-se a nós! Complete o registo</p>
    </div>

    <!-- ERROS (se existirem) -->
    @if ($errors->any())
    <div style="padding: 0 2rem; padding-top: 1.5rem;">
        <div class="error-container">
            <strong><x-heroicon-s-exclamation-triangle /> Erro ao criar conta:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- FORMULÁRIO DE REGISTO -->
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        <!-- Nome de Utilizador -->
        <div class="form-group">
            <label for="name" class="form-label"><x-heroicon-c-user-circle style="color: var(--main_color); width: 1.25rem; height: 1.25rem;"/> Nome de Utilizador</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                class="form-input {{ $errors->has('name') ? 'is-invalid' : '' }}"
                value="{{ old('name') }}"
                placeholder="João Silva"
                required
                autofocus
                autocomplete="name"
            />
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label"><x-heroicon-c-envelope style=" color: var(--main_color); width: 1.25rem; height: 1.25rem;"/> Endereço de Email</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                value="{{ old('email') }}"
                placeholder="seu.email@example.com"
                autocomplete="email"
                required
            />
        </div>

        <!-- Palavra-passe -->
        <div class="form-group">
            <label for="password" class="form-label"><x-heroicon-s-lock-closed style="color: var(--main_color); width: 1.25rem; height: 1.25rem;"/> Palavra-passe</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="new-password"
                minlength="8"
                onchange="checkPasswordStrength()"
                oninput="checkPasswordStrength()"
            />
            <div class="password-strength">
                <div class="password-strength-bar" id="passwordStrengthBar"></div>
            </div>
            <small class="password-strength-text" id="passwordStrengthText"></small>
            <span class="helper-text">Mínimo 8 caracteres</span>
        </div>

        <!-- Confirmar Palavra-passe -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label"><x-heroicon-s-lock-closed style="width: 1.25rem; height: 1.25rem; color: var(--main_color);"/> Confirmar Palavra-passe</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="new-password"
            />
        </div>

        <!-- Botão Submit -->
        <button type="submit"class="btn-submit"
        onclick="this.disabled=true; this.form.submit();">
            Criar Conta
        </button>

    </form>

    <!-- RODAPÉ - LINK PARA LOGIN -->
    <div class="auth-footer">
        <p>Já tem conta?</p>
        <a href="{{ route('login') }}">Inicie sessão aqui →</a>
    </div>
</div>
</main>

@include('partial/footer')

<script>
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthBar = document.getElementById('passwordStrengthBar');
        const strengthText = document.getElementById('passwordStrengthText');

        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        strengthBar.className = 'password-strength-bar';
        strengthText.className = 'password-strength-text';

        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthText.classList.remove('show');
        } else if (strength <= 2) {
            strengthBar.classList.add('weak');
            strengthText.classList.add('show');
            strengthText.textContent = '❌ Fraca - Adicione maiúsculas, números e símbolos';
            strengthText.style.color = '#dc3545';
        } else if (strength === 3) {
            strengthBar.classList.add('medium');
            strengthText.classList.add('show');
            strengthText.textContent = '<x-heroicon-s-exclamation-triangle /> Média - Melhore adicionando mais caracteres especiais';
            strengthText.style.color = '#ffc107';
        } else {
            strengthBar.classList.add('strong');
            strengthText.classList.add('show');
            strengthText.textContent = '✅ Forte - Excelente segurança!';
            strengthText.style.color = '#28a745';
        }
    }
</script>

</body>
</html>

