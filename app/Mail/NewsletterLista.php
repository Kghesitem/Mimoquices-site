<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NewsletterLista extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $produtos;
    public $user;
    public $texto;
    public $unsubscribeUrl;

    public function __construct($produtos, $user, $texto = null)
    {
        $this->produtos = $produtos;
        $this->user = $user;
        $this->texto = $texto;

        // Gera o link assinado e seguro aqui dentro, tal como na outra!
        $this->unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['user' => $user->id]);
    }

    /**
     * Constrói o e-mail usando o método clássico build()
     */
    public function build()
    {
        return $this->subject('Novidades Mimoquices')
                    ->view('emails.newsletter');
    }
}
