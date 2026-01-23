<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mimoquices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png')}}" size="32x32">
    
</head>
<body>
    <nav>
        <a class="logo" href="{{ route('welcome') }}"><img src="{{ asset('frontend/assets/img/logo 2021vfinal.jpg')}}" alt=""></a>

        
        <input type="checkbox" id="sidebar-active">
        <label for="sidebar-active" class="open">
            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="M120-240v-66.67h720V-240H120Zm0-206.67v-66.66h720v66.66H120Zm0-206.66V-720h720v66.67H120Z"/></svg>
        </label>

        <label id="overlay"for="sidebar-active"></label>
        <div class="link-container">
            <label for="sidebar-active" class="close">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#e3e3e3"><path d="m251.33-204.67-46.66-46.66L433.33-480 204.67-708.67l46.66-46.66L480-526.67l228.67-228.66 46.66 46.66L526.67-480l228.66 228.67-46.66 46.66L480-433.33 251.33-204.67Z"/></svg>
            </label>

        
            @if (Route::currentRouteName() == 'welcome')
                <a class="paginas active" href="{{ route('welcome') }}">Home</a>
            @else
                <a class="paginas" href="{{ route('welcome') }}">Home</a>
            @endif

            @if (Route::currentRouteName() == 'sobre')
                <a  class="paginas active" href="{{ route('sobre') }}" >Sobre nós</a>
            @else
                <a  class="paginas" href="{{ route('sobre') }}" >Sobre nós</a>
            @endif
            
            @if (Route::currentRouteName() == 'produto.index')
                <a class="paginas active" href="{{ route('produto.index') }}">Produtos</a>
            @else
                <a class="paginas" href="{{ route('produto.index') }}">Produtos</a>
            @endif
            
            
    @if (Route::has('login'))
    @auth
        
        <div class="paginas dropdown">
            <a
                href="#"
                class="dropdown-toggle"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="true"
            >
                Olá, {{ Auth::user()->name }}
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <form
                        method="POST"
                        action="{{ route('logout') }}"
                        
                    >
                        @csrf

                        <button
                            type="submit"
                            class="dropdown-item"
                        >
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
                <a class="social-links" href="" target="_blank"><img src="{{ asset('frontend/assets/img/instagram.png')}}" alt=""></a>
                <a class="social-links" href="" target="_blank"><img src="{{ asset('frontend/assets/img/facebook.png')}}" alt=""></a>
                <a class="social-links" href="" target="_blank"><img src="{{ asset('frontend/assets/img/email.png')}}" alt=""></a>              
            </div>
        </div>
    </nav>
