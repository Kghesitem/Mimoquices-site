@include('partial/header')
<head>
    <title>Perfil de Utilizador - Mimoquices</title>
</head>
<body class="bg-light">
    
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
                        <span class="summary-title"><i class="icon"><x-heroicon-s-exclamation-triangle style="width:4rem; heigth:4rem"/></i> Zona de Perigo</span>
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