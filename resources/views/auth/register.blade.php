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
    {{-- CABEÇALHO DO FORMULÁRIO --}}
    <div class="auth-header">
        <h1><x-heroicon-s-user-plus style="width: 2rem; height: 2rem;"/> Criar Conta</h1>
        <p>Junte-se a nós! Complete o registo</p>
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

    {{-- FORMULÁRIO DE REGISTO --}}
    <form method="POST" action="{{ route('register') }}" class="auth-form">
        @csrf

        {{-- Nome de Utilizador --}}
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

        {{-- Email --}}
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

        {{-- Palavra-passe --}}
        <div class="form-group">
            <label for="password" class="form-label">
                <x-heroicon-s-lock-closed style="color: var(--main_color); width: 1.25rem; height: 1.25rem;"/> Palavra-passe
            </label>
            <input
                type="password"
                id="password"
                name="password"
                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="new-password"
                minlength="8"
                oninput="checkPasswordStrength()"
            />
            <div class="password-strength">
                <div class="password-strength-bar" id="passwordStrengthBar"></div>
            </div>

            {{-- Contentor da mensagem de força --}}
            <div id="passwordStrengthContainer" class="password-strength-text" style="display: none; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                <span id="icon-weak" style="display: none; color: #dc3545;"><x-heroicon-o-x-mark style="width:1.25rem; height:1.25rem;"/></span>
                <span id="icon-medium" style="display: none; color: #ffc107;"><x-heroicon-s-exclamation-triangle style="width:1.25rem; height:1.25rem;"/></span>
                <span id="icon-strong" style="display: none; color: #28a745;"><x-heroicon-c-check-circle style="width:1.25rem; height:1.25rem;"/></span>

                <span id="passwordStrengthText"></span>
            </div>

            <span class="helper-text">Mínimo 8 caracteres</span>
        </div>

        {{-- Confirmar Palavra-passe --}}
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

        {{-- Newsletter Checkbox --}}
        <div class="form-group-checkbox" style="display: flex; align-items: flex-start; gap: 0.5rem; margin: 1rem 0;">
            <input
                type="checkbox"
                id="newsletter"
                name="newsletter"
                value="1"
                class="form-checkbox"
                autocomplete="off" {{-- Corrigido de "newsletter" para "off" --}}
            />
            <label for="newsletter" class="form-label-checkbox" style="cursor: pointer; user-select: none; font-size: 0.9rem; color: #4a5568;">
                Quero receber novidades e promoções por email
            </label>
        </div>

        {{-- Botão Submit Atualizado --}}
        <button type="submit" id="btnSubmit" class="btn-submit">
            <span class="btn-text">Criar Conta</span>
            <span class="btn-spinner" style="display: none;">A processar...</span>
        </button>

    </form>

    <div class="auth-footer">
        <p>Já tem conta?</p>
        <a href="{{ route('login') }}">Inicie sessão aqui →</a>
    </div>
</div>
</main>

@include('partial/footer')

<script>
    // Validação visual da barra de força
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthBar = document.getElementById('passwordStrengthBar');
        const container = document.getElementById('passwordStrengthContainer');
        const strengthText = document.getElementById('passwordStrengthText');

        const iconWeak = document.getElementById('icon-weak');
        const iconMedium = document.getElementById('icon-medium');
        const iconStrong = document.getElementById('icon-strong');

        let strength = 0;

        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        if (/[0-9]/.test(password)) strength++;
        if (/[^a-zA-Z0-9]/.test(password)) strength++;

        strengthBar.className = 'password-strength-bar';
        iconWeak.style.display = 'none';
        iconMedium.style.display = 'none';
        iconStrong.style.display = 'none';

        if (password.length === 0) {
            strengthBar.style.width = '0%';
            container.style.display = 'none';
            return;
        }

        container.style.display = 'flex';

        if (strength <= 2) {
            strengthBar.classList.add('weak');
            strengthBar.style.width = '33%';
            iconWeak.style.display = 'inline-block';
            strengthText.textContent = 'Fraca - Adicione maiúsculas, números e símbolos';
            container.style.color = '#dc3545';
        } else if (strength === 3) {
            strengthBar.classList.add('medium');
            strengthBar.style.width = '66%';
            iconMedium.style.display = 'inline-block';
            strengthText.textContent = 'Média - Melhore adicionando mais caracteres especiais';
            container.style.color = '#ffc107';
        } else {
            strengthBar.classList.add('strong');
            strengthBar.style.width = '100%';
            iconStrong.style.display = 'inline-block';
            strengthText.textContent = 'Forte - Excelente segurança!';
            container.style.color = '#28a745';
        }
    }

    // Comportamento inteligente do Botão Real ao submeter
    document.querySelector('.auth-form').addEventListener('submit', function(e) {
        const btn = document.getElementById('btnSubmit');
        const btnText = btn.querySelector('.btn-text');
        const btnSpinner = btn.querySelector('.btn-spinner');

        if (this.checkValidity()) {
            btn.disabled = true;
            if (btnText && btnSpinner) {
                btnText.style.display = 'none';
                btnSpinner.style.display = 'inline-block';
            }
        }
    });
</script>

</body>
</html>
