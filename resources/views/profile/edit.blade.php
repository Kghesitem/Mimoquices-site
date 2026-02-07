<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Perfil do Utilizador - Mimoquices</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
</head>
<body class="bg-light">

@include('partial/header')

<main class="profile-page py-5">
    <div class="container">
        <div class="profile-card">
            
            {{-- Cabeçalho do Perfil --}}
            <header class="profile-header text-center">
                <div class="profile-avatar-placeholder">
                    <span>{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <h1>A minha conta</h1>
                <p>Gerir dados pessoais e segurança</p>
            </header>

            <div class="profile-sections">

                {{-- INFORMAÇÕES DO PERFIL --}}
                <details class="accordion-profile" open>
                    <summary>
                        <span class="summary-title"><i class="icon">👤</i> Informações do Perfil</span>
                        <span class="arrow">▾</span>
                    </summary>
                    <div class="accordion-content">
                        <div class="inner-form-wrapper">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </details>

                {{-- ALTERAR PALAVRA-PASSE --}}
                <details class="accordion-profile">
                    <summary>
                        <span class="summary-title"><i class="icon">🔒</i> Segurança da Conta</span>
                        <span class="arrow">▾</span>
                    </summary>
                    <div class="accordion-content">
                        <div class="inner-form-wrapper">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </details>

                {{-- ELIMINAR CONTA --}}
                <details class="accordion-profile danger-zone">
                    <summary>
                        <span class="summary-title"><i class="icon">⚠️</i> Zona de Perigo</span>
                        <span class="arrow">▾</span>
                    </summary>
                    <div class="accordion-content">
                        <div class="inner-form-wrapper">
                            <p class="text-muted small mb-4">Uma vez eliminada, todos os dados serão perdidos permanentemente.</p>
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </details>

            </div>

            <footer class="profile-footer">
                <p>Mimoquices &bull; Todos os dados são tratados de forma segura.</p>
            </footer>
        </div>
    </div>
</main>

@include('partial/footer')

</body>
</html>