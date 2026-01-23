<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PersonalizarMail extends Mailable
{
    public $produto;
    public $personalizacoes;

    public function __construct($produto, $personalizacoes)
    {
        $this->produto = $produto;
        $this->personalizacoes = $personalizacoes;
    }

    public function build()
    {
        return $this->subject('Confirmação da personalização do seu produto')
                    ->view('emails.personalizacoes');
    }
}

