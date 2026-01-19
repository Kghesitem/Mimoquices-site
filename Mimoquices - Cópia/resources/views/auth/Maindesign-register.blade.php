
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --main_color: #c89286;
            --color1: #0f1016;
            --color-light: #f8f9fa;
            --color-border: rgba(200, 146, 134, 0.3);
            --color-error: #dc3545;
            --color-success: #28a745;
        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f8f9fa;
        }

        /* ================= WRAPPER COM HEADER E FOOTER ================= */
        main {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 300px);
            padding: 3rem 1rem;
        }

        /* ================= CONTAINER PRINCIPAL ================= */
        .auth-container {
            background: white;
            border-radius: 1.5rem;
            border: 2px solid var(--color-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 450px;
            width: 100%;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ================= CABEÇALHO DO FORMULÁRIO ================= */
        .auth-header {
            background: linear-gradient(135deg, var(--main_color) 0%, #b87772 100%);
            padding: 2.5rem 2rem;
            text-align: center;
            color: white;
        }

        .auth-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: 0.5px;
        }

        .auth-header p {
            font-size: 0.95rem;
            opacity: 0.95;
        }

        /* ================= FORMULÁRIO ================= */
        .auth-form {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.6rem;
            font-weight: 600;
            color: var(--color1);
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.85rem 1rem;
            border: 2px solid var(--color-border);
            border-radius: 0.75rem;
            font-size: 0.95rem;
            font-family: 'Poppins', Arial, sans-serif;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--main_color);
            background-color: white;
            box-shadow: 0 0 0 3px rgba(200, 146, 134, 0.1);
        }

        .form-input::placeholder {
            color: #aaa;
        }

        .form-input.is-invalid {
            border-color: var(--color-error);
            background-color: #fff5f5;
        }

        /* ================= ERROS ================= */
        .error-container {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1.5rem;
            animation: shake 0.4s ease;
        }

        .error-container strong {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .error-container ul {
            margin: 0;
            padding-left: 1.5rem;
            font-size: 0.9rem;
        }

        .error-container li {
            margin-bottom: 0.25rem;
        }

        .field-error {
            color: var(--color-error);
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: block;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* ================= PASSWORD STRENGTH ================= */
        .password-strength {
            margin-top: 0.5rem;
            height: 3px;
            border-radius: 3px;
            background-color: #eee;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            border-radius: 3px;
            transition: all 0.3s ease;
            width: 0%;
        }

        .password-strength-bar.weak {
            width: 33%;
            background-color: #dc3545;
        }

        .password-strength-bar.medium {
            width: 66%;
            background-color: #ffc107;
        }

        .password-strength-bar.strong {
            width: 100%;
            background-color: #28a745;
        }

        .password-strength-text {
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: none;
        }

        .password-strength-text.show {
            display: block;
        }

        /* ================= BOTÕES ================= */
        .btn-submit {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background-color: var(--main_color);
            color: white;
            border: none;
            border-radius: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .btn-submit:hover {
            background-color: #b87772;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(200, 146, 134, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* ================= RODAPÉ DO FORM ================= */
        .auth-footer {
            background-color: #f9f9f9;
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid var(--color-border);
        }

        .auth-footer p {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        .auth-footer a {
            color: var(--main_color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-footer a:hover {
            color: #b87772;
            text-decoration: underline;
        }

        /* ================= HELPER TEXT ================= */
        .helper-text {
            color: #999;
            font-size: 0.85rem;
            margin-top: 0.3rem;
            display: block;
        }

        /* ================= RESPONSIVO ================= */
        @media (max-width: 480px) {
            .auth-header {
                padding: 1.5rem;
            }

            .auth-header h1 {
                font-size: 1.5rem;
            }

            .auth-form {
                padding: 1.5rem;
            }

            main {
                min-height: calc(100vh - 250px);
                padding: 1.5rem 0.5rem;
            }
        }
    </style>
</head>
<body>

@include('partial/header')

<main>
<div class="auth-container">
    <!-- CABEÇALHO DO FORMULÁRIO -->
    <div class="auth-header">
        <h1>✨ Criar Conta</h1>
        <p>Junte-se a nós! Complete o registo</p>
    </div>

    <!-- ERROS (se existirem) -->
    @if ($errors->any())
    <div style="padding: 0 2rem; padding-top: 1.5rem;">
        <div class="error-container">
            <strong>⚠️ Erro ao criar conta:</strong>
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
            <label for="name" class="form-label">👤 Nome de Utilizador</label>
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
            @error('name')
            <span class="field-error">O nome é obrigatório</span>
            @enderror
        </div>

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
                autocomplete="email"
            />
            @error('email')
            <span class="field-error">Email inválido ou já registado</span>
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
            @error('password')
            <span class="field-error">Palavra-passe fraca. Use maiúsculas, números e símbolos</span>
            @enderror
        </div>

        <!-- Confirmar Palavra-passe -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">🔐 Confirmar Palavra-passe</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="form-input {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                placeholder="••••••••"
                required
                autocomplete="new-password"
            />
            @error('password_confirmation')
            <span class="field-error">As palavras-passe não correspondem</span>
            @enderror
        </div>

        <!-- Botão Submit -->
        <button type="submit" class="btn-submit">
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
            strengthText.textContent = '⚠️ Média - Melhore adicionando mais caracteres especiais';
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

