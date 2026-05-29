<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function unsubscribe(Request $request, User $user)
    {
        if (! $request->hasValidSignature()) {
            abort(401, 'Este link de cancelamento expirou ou é inválido.');
        }

        $user->update(['newsletter' => 0]);

        return redirect('/')->with('success', 'A tua subscrição da newsletter foi cancelada.');
    }
}