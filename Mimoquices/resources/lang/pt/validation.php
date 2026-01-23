<?php

return [

    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute tem de ser um endereço de email válido.',
    'min' => [
        'string' => 'O campo :attribute tem de ter pelo menos :min caracteres.',
    ],
    'max' => [
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
    ],
    'confirmed' => 'A confirmação de :attribute não corresponde.',

    'attributes' => [
        'name' => 'nome',
        'email' => 'email',
        'password' => 'palavra-passe',
        'password_confirmation' => 'confirmação da palavra-passe',
    ],

];
