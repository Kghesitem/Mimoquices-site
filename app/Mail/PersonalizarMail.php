<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PersonalizarMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $pedido;
    public $itens;
    public $pesonalizacoes;
    public $selecionadas;

    public function __construct($pedido, $itens, $pesonalizacoes, $selecionadas)
    {
        $this->pedido = $pedido;
        $this->itens = $itens;
        $this->pesonalizacoes = $pesonalizacoes;
        $this->selecionadas = $selecionadas;
    }

    public function build()
    {
        return $this->subject('Confirmação de Personalização')
                    ->view('emails.personalizacoes');
    }
}
