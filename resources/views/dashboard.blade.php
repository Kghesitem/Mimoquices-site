@include('partial.header')
<head>
    <title>Dashboard - Mimoquices</title>
</head>
    <div class="py-12 dashboard-mimo">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Saudação --}}
            <div class="welcome-banner mb-8">
                <h1>Olá, {{ Auth::user()->name }}!</h1>
            </div>

            {{-- Grelha de Atalhos --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                {{-- Card: Perfil --}}
                <a href="{{ route('profile.edit') }}" class="dash-card">
                    <div class="dash-icon">👤</div>
                    <h3>O Meu Perfil</h3>
                    <p>Edita os teus dados e muda a tua password.</p>
                    <span class="dash-link">Gerir conta →</span>
                </a>

                {{-- Card: Personalizações (Exemplo de rota) --}}
                <a href="{{ route('historico') }}" class="dash-card">
                    <div class="dash-icon">📦</div>
                    <h3>Personalizações</h3>
                    <p>Vê o estado e o histórico de personalizações.</p>
                    <span class="dash-link">Ver histórico →</span>
                </a>

                {{-- Card: Suporte/Contacto --}}
                <a href="https://www.instagram.com/mimoquices.mv/" class="dash-card">
                    <div class="dash-icon">✨</div>
                    <h3>Mimos e Ajuda</h3>
                    <p>Tens alguma dúvida? Estamos aqui para ajudar.</p>
                    <span class="dash-link">Contactar →</span>
                </a>
                
            </div>
        </div>
    </div>
@include('partial.footer')
