<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class NewsletterProduto extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $produto;
    public $user;
    public $unsubscribeUrl;

    public function __construct($produto, $user)
    {
        $this->produto = $produto;
        $this->user = $user;

        $this->unsubscribeUrl = URL::signedRoute('newsletter.unsubscribe', ['user' => $user->id]);
    }

    public function build()
    {
        return $this->subject('Novidade fresquinha na Mimoquices!')
                    ->view('emails.NewsletterProduto');
    }
}
