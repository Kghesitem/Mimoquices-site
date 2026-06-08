<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Produto;
use Illuminate\Support\Facades\Mail;
use App\Models\Tipo;
use App\Mail\Newsletter_lista;

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

    public function create()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->get();
        $tipos = Tipo::orderBy('categoria', 'asc')->get();
        return view('newsletter.criar', compact('produtos', 'tipos'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'produtos_ids' => 'required|array|min:1',
            'produtos_ids.*' => 'exists:produto,id',
        ], [
            'produtos_ids.required' => 'Precisas de selecionar pelo menos um produto para enviar a newsletter.'
        ]);

        $produtosSelecionados = Produto::whereIn('id', $request->produtos_ids)->get();
        $subscritores = User::where('newsletter', 1)->whereNotNull('email_verified_at')->get();

        if ($subscritores->isEmpty()) {
            return redirect()->back()->withErrors(['erro' => 'Não existem utilizadores subscritos na newsletter.']);
        }

        foreach ($subscritores as $user) {
            Mail::to($user->email)->queue(
                new Newsletter_lista($produtosSelecionados, $user)
            );
        }

        return redirect()->route('dashboard')->with('success', 'Newsletter adicionada à fila de envio com sucesso para ' . $subscritores->count() . ' subscritores!');
    }
}