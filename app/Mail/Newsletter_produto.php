<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class Newsletter_produto extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    // 💡 IMPORTANTE: Declarar ambas as propriedades como públicas
    public $produto;
    public $user; 
    public $unsubscribeUrl; 

    public function __construct($produto, $user)
    {
        $this->produto = $produto;
        $this->user = $user; // 💡 Guarda o modelo do utilizador aqui

        // Gera o link assinado baseado no ID do utilizador
        $this->unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['user' => $user->id]);
    }

    public function build()
    {
        return $this->subject('Novidade fresquinha na Mimoquices!')
                    ->view('emails.newsletter_produto');
    }
}