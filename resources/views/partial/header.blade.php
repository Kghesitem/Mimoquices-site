<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mimoquices</title>

    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">

    <script src="{{ asset('frontend/assets/js/sweetalert2.all.min.js') }}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/img/logo.png') }}" sizes="32x32">
</head>
<body>
    <nav>
        {{-- Corrigido: Adicionado alt descritivo e limpo o espaço na URL do asset --}}
        <a class="logo" href="{{ route('welcome') }}">
            <img src="{{ asset('frontend/assets/img/logo.png') }}" alt="Logótipo Mimoquices">
        </a>

        {{-- O input que controla o estado do menu móvel --}}
        <input type="checkbox" id="sidebar-active">

        {{-- Botão de Hambúrguer (Abre o menu) --}}
        <label for="sidebar-active" class="open" aria-label="Abrir menu de navegação">
            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="M120-240v-66.67h720V-240H120Zm0-206.67v-66.66h720v66.66H120Zm0-206.66V-720h720v66.67H120Z"/></svg>
        </label>

        {{-- Corrigido (L27): Fundo escuro focado em fechar o menu ao clicar fora --}}
        <label id="overlay" for="sidebar-active" aria-label="Fechar menu"></label>

        <div class="link-container">
            {{-- Corrigido (L31): Botão de 'X' para fechar o menu no telemóvel --}}
            <label for="sidebar-active" class="close" aria-label="Fechar menu de navegação">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="m251.33-204.67-46.66-46.66L433.33-480 204.67-708.67l46.66-46.66L480-526.67l228.67-228.66 46.66 46.66L526.67-480l228.66 228.67-46.66 46.66L480-433.33 251.33-204.67Z"/></svg>
            </label>

            @if (Route::currentRouteName() == 'welcome')
                <a class="paginas active" href="{{ route('welcome') }}">Home</a>
            @else
                <a class="paginas" href="{{ route('welcome') }}">Home</a>
            @endif

            @if (Route::currentRouteName() == 'sobre')
                <a class="paginas active" href="{{ route('sobre') }}" >Sobre nós</a>
            @else
                <a class="paginas" href="{{ route('sobre') }}" >Sobre nós</a>
            @endif

            @if (Route::currentRouteName() == 'produto.index')
                <a class="paginas active" href="{{ route('produto.index') }}">Produtos</a>
            @else
                <a class="paginas" href="{{ route('produto.index') }}">Produtos</a>
            @endif

            @if (Route::has('login'))
                @auth
                    @if (Route::currentRouteName() == 'favoritos')
                        <a class="paginas active" href="{{ route('favoritos') }}">Favoritos</a>
                    @else
                        <a class="paginas" href="{{ route('favoritos') }}">Favoritos</a>
                    @endif

                    <div class="paginas dropdown">
                        <button
                            type="button"
                            class="dropdown-toggle"
                            style="background: none; border: none; padding: 0; color: inherit; font: inherit; cursor: pointer;"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Olá, {{ Auth::user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ url('/dashboard') }}">Painel de Controlo</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ url('/profile') }}">Perfil</a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="login-logout" href="{{ route('login') }}">Login / Registar</a>
                @endauth
            @endif

            <div class="social-links-container">
                <a class="social-links" href="https://www.instagram.com/mimoquices.mv/" target="_blank">
                    <img src="{{ asset('frontend/assets/img/instagram.png') }}" alt="Instagram">
                </a>
                <a class="social-links" href="https://www.facebook.com/mimoquicesmv/" target="_blank">
                    <img src="{{ asset('frontend/assets/img/facebook.png') }}" alt="Facebook">
                </a>

                <button
                    type="button"
                    class="social-links"
                    onclick="copiarEmail()"
                    style="background: none; border: none; padding: 0; cursor: pointer;"
                    aria-label="Copiar endereço de e-mail"
                >
                    <img src="{{ asset('frontend/assets/img/email.png') }}" alt="Ícone de E-mail">
                </button>
            </div>
        </div>
    </nav>
