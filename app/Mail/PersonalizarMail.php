<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PersonalizarMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $produto;
    public $personalizacoes;

    /**
     * @param mixed $produto
     * @param array $personalizacoes
     */
    public function __construct($produto, array $personalizacoes)
    {
        $this->produto = $produto;
        $this->personalizacoes = $personalizacoes;
    }

    public function build()
    {
        return $this->subject('Confirmação da personalização do seu produto')
                    ->view('emails.personalizacoes')
                    ->with([
                        'produto' => $this->produto,
                        'personalizacoes' => $this->personalizacoes,
                    ]);
    }
}