<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vereficação de e-mail- Mimoquices</title>    
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>


@include('partial/header')
<main>
    <div class="auth-container">
        <div class="auth-header">
            <h1>📧 Verificar E-mail</h1>
            <p>Falta pouco! Confirme o seu endereço de e-mail para continuar.</p>
        </div>

        <div style="padding: 1.1rem 1.5rem 0;">
            @if (session('status') == 'verification-link-sent')
                <div class="status-success" style="background-color: #dcfce7; color: #166534; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem; border: 1px solid #bbf7d0;">
                    {{ __('Um novo link de verificação foi enviado para o e-mail que forneceu no registo.') }}
                </div>
            @endif

            <div style="color: #4b5563; line-height: 1.6; margin-bottom: 1.5rem; text-align: center;">
                {{ __('Obrigado por te registares! Antes de começares, clica no link que acabámos de enviar para o teu e-mail. Se não recebeste nada, podemos enviar outro.') }}
            </div>
        </div>

        <div class="auth-form">
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-submit" onclick="this.disabled=true; this.form.submit();">
                        {{ __('Reenviar E-mail de Verificação') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" style="text-align: center; margin-top: 0.5rem;">
                    @csrf
                    <button type="submit" style="background: none; border: none; color: #6b7280; text-decoration: underline; font-size: 0.875rem; cursor: pointer;">
                        {{ __('Sair da Conta') }}
                    </button>
                </form>
            </div>
        </div>

        <div class="auth-footer">
            <p>Algum problema?</p>
            <a href="mailto:suporte@mimoquices.com">Contactar Suporte →</a>
        </div>
    </div>
</main>

@include('partial/footer')