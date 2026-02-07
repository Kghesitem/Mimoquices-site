<?php

namespace App\Http\Controllers;

use App\Models\Personalizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;

class PersonalizacaoController extends Controller
{
    public function index()
    {
        $historico = Personalizacao::whereHas('pedido', function ($query) {
            $query->where('id_user', Auth::id()); 
        })
        ->with('produto') 
        ->latest()
        ->get();

        return view('historico_personalizacoes', compact('historico'));
    }
    public function destroy($id)
{
    // 1. Encontrar o pedido
    $pedido = Pedido::findOrFail($id);

    // 2. Verificar se o pedido pertence ao utilizador logado
    if ($pedido->id_user !== auth()->id()) {
        return back()->with('error', 'Não tens permissão para isto.');
    }

    // 3. LOGICA DE ELIMINAÇÃO (Mais flexível com o texto)
    // Usamos trim e lowercase para evitar erros de escrita
    $estadoAtual = mb_strtolower(trim($pedido->estado));

    if ($estadoAtual === 'não visto' || $estadoAtual === 'pendente') {
        
        // Apagamos as personalizações primeiro (importante!)
        \App\Models\Personalizacao::where('id_pedido', $id)->delete();
        
        // Apagamos o pedido
        $pedido->delete();

        return back()->with('success', 'Pedido eliminado com sucesso!');
    }

    // Se chegar aqui, é porque o IF falhou. Vamos enviar o erro para saberes porquê.
    return back()->with('error', 'Não foi possível eliminar. O estado atual é: "' . $pedido->estado . '"');
}}