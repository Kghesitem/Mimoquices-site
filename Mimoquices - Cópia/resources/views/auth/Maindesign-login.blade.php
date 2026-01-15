<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mimoquices-Login</title>
        <link rel="stylesheet" href="frontend/assets/css/style.css">
            <link rel="icon" type="image/png" style="border-radius: .5em;" href="frontend/assets/img/logo.png">
</head>
<body>

    <div class="img">
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- Logo -->
    <div class="logo-login">
        <a class="logo-login" href="{{ route('welcome') }}"><img src="frontend/assets/img/logo 2021vfinal.jpg" alt="logo.jpg"></a>
    </div>
    <!-- Form para login e para registar -->
    <div class="login-register">
            <div class="centrador">
            <button class="tab-button active">Log in</button>
            <a href="{{ route('register') }}" class="tab-button">Registar</a>
    </div>
    
    @if ($errors->has('email') || $errors->has('password'))
        <div class="centrador">
            <div class="erro">
                <x-input-error :messages="$errors->get('email')" />
                <x-input-error :messages="$errors->get('password')" />
            </div>
        </div>
    @endif
    

    <!-- Formulário do login -->
    <form method="post" action="{{ route('login') }}" class="form-login">
    @csrf
            <h1>Iniciar sessão</h1>
            <!-- Edereço de email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="label"/>
                <x-text-input id="email" class="input-login" type="email" name="email" :value="old('email')" required autofocus placeholder="exemplo@gmail.com" autocomplete="username" />
                
            </div>


            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="label"/>

                <x-text-input id="password" class="input-login"
                                type="password"
                                name="password"
                                required autocomplete="current-password"
                                placeholder="*********" />

               
            </div>


            <!-- Recoperar Password  -->
            <div class="label">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="login-logout ">
                    Esqueceste-te da palavra-passe?
                </a>
            @endif
            <!-- Botão de login -->
                <x-primary-button class="btn-submit">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
    </div>
</body>
</html>

