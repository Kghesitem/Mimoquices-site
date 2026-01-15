
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mimoquices-Registar</title>
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
            <a href="{{ route('login') }}" class="tab-button">Log in</a>
            <button class="tab-button active">Registar</button>
    </div>
    
    @if ($errors->has('email') || $errors->has('password'))
        <div class="centrador">
            <div class="erro">
                <x-input-error :messages="$errors->get('email')" />
                <x-input-error :messages="$errors->get('password')" />
            </div>
        </div>
    @endif

    <!-- Formulário do register -->
    <form method="post" action="{{ route('register') }}" class="form-login">
    @csrf
            <h1>Registar conta</h1>

            <!-- Nome de utilizador -->
            <div>
                <label for="name" :value="__('Name')" class="label">Nome de utilizador</label>
                <x-text-input id="name" class="input-login" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus  
                                placeholder="João123"
                                autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="label"/>
            </div>

            <!-- Edereço de email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" class="label"/>
                <x-text-input id="email" class="input-login" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                placeholder="exemplo@gmail.com" 
                                autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="label" />
            </div>


            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="label"/>

                <x-text-input id="password" class="input-login"
                                type="password"
                                name="password"
                                required autocomplete="new-password"
                                placeholder="*********" />

                <x-input-error :messages="$errors->get('password')" class="label"/>
            </div>


             <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="label" />

                <x-text-input id="password_confirmation" class="input-login"
                                type="password"
                                name="password_confirmation" 
                                required autocomplete="new-password"
                                placeholder="*********" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="label"/>
            </div>



            <!-- butão para logar se já tiver conta
            <div class="label">
            <a href="{{ route('login') }}"class="login-logout ">
                Já Registado?
            </a>-->
            <!-- Botão de login -->
                <x-primary-button class="btn-submit">
                    Registar
                </x-primary-button>

        </div>
    </form>
    </div>
</body>
</html>

