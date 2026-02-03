<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Importante para ativar a verificação
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail; // Adicionado para verificação
use Illuminate\Notifications\Messages\MailMessage; 

class User extends Authenticatable implements MustVerifyEmail // Implementação da interface
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Personalização do E-mail de Reset de Password
     */
    public function sendPasswordResetNotification($token)
    {
        $url = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));

        $this->notify(new class($url) extends ResetPassword {
            protected $url;
            public function __construct($url) { $this->url = $url; }

            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('🔐 Recuperar Palavra-passe - Mimoquices')
                    ->view('emails.reset', ['url' => $this->url]);
            }
        });
    }

    /**
     * Personalização do E-mail de Verificação de Conta
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new class extends VerifyEmail {
            public function toMail($notifiable)
            {
                $verificationUrl = $this->verificationUrl($notifiable);

                return (new MailMessage)
                    ->subject('📧 Confirma o teu e-mail - Mimoquices')
                    ->view('emails.verify', ['url' => $verificationUrl]);
            }
        });
    }
}