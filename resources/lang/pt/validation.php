<?php

return [

    'required' => 'O/A :attribute é obrigatório.',
    'email' => 'O Email não é válido.',
    'min' => [
        'string' => 'O/A :attribute tem de ter pelo menos :min caracteres.',
    ],
    'max' => [
        'string' => 'O/A :attribute não pode ter mais de :max caracteres.',
    ],
    'confirmed' => 'A confirmação de :attribute não corresponde.',
    'unique' => 'O :attribute já está a ser utilizado',

    'attributes' => [
        'name' => 'nome',
        'email' => 'email',
        'password' => 'palavra-passe',
        'password_confirmation' => 'confirmação da palavra-passe',
    ],

    'password' => [
        'letters' => 'A palavra-passe deve conter pelo menos uma letra.',
        'mixed'   => 'A palavra-passe deve conter letras maiúsculas e minúsculas.',
        'numbers' => 'A palavra-passe deve conter pelo menos um número.',
        'symbols' => 'A palavra-passe deve conter pelo menos um carácter especial.',
    ],

];
