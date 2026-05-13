<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Produto;
use App\Models\Tipo;
use App\Models\Favoritos;
use Illuminate\Support\Facades\DB;
use App\Models\Personalizacao;

class UserController extends Controller
{
    public function Dashboard()
    {
        if (Auth::check() && Auth::user()->user_type === 'user') {
            return view('dashboard');
        }

        if (Auth::check() && Auth::user()->user_type === 'admin') {
            $produtos = Produto::all();
            $tipos = Tipo::all();

            // Dados do Gráfico de Favoritos (Redondo)
            $favoritos = Favoritos::select('id_produto', DB::raw('count(*) as total'))
                ->with('produto')->groupBy('id_produto')->orderBy('total', 'desc')->take(15)->get();

            // Dados do Gráfico de Pedidos (Barras)
            $pedidosData = Personalizacao::select('id_produto', DB::raw('count(DISTINCT id_pedido) as total'))
            ->with('produto')->groupBy('id_produto')->orderBy('total', 'desc')->take(15)->get();

            
            $labels = $favoritos->map(fn($f) => $f->produto->titulo ?? 'Desconhecido');
            $valores = $favoritos->pluck('total');

            $labelsPedidos = $pedidosData->map(fn($p) => $p->produto->titulo ?? 'Desconhecido');
            $valoresPedidos = $pedidosData->pluck('total');

            return view('admin.dashboard', [
                'produtos' => $produtos,
                'tipos' => $tipos,
                'labels' => $labels,
                'valores' => $valores,
                'labelsPedidos' => $labelsPedidos,
                'valoresPedidos' => $valoresPedidos,
            ]);
        }

        return redirect('/');
    }
    
}
