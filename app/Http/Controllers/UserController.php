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
    // CORREÇÃO: Alterado de Dashboard para dashboard (camelCase)
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->user_type === 'user') {
            return view('dashboard');
        }

        if (Auth::check() && Auth::user()->user_type === 'admin') {

            // 1. Dados gerais para as listagens
            $produtos = Produto::all();
            $tipos = Tipo::all();

            $favoritos = Favoritos::select('id_produto', DB::raw('count(*) as total'))
                ->with('produto')
                ->groupBy('id_produto')
                ->orderBy('total', 'desc')
                ->take(15)
                ->get();

            $labels = $favoritos->map(fn($f) => $f->produto->titulo ?? 'Desconhecido');
            $valores = $favoritos->pluck('total');

            $produtosPorTipo = Tipo::withCount('produtos')->get();

            $labelsTipos = $produtosPorTipo->pluck('Categoria');
            $valoresTipos = $produtosPorTipo->pluck('produtos_count');

            return view('admin.dashboard', [
                'produtos' => $produtos,
                'tipos' => $tipos,
                'labels' => $labels,
                'valores' => $valores,
                'labelsTipos' => $labelsTipos, // Passado para a view
                'valoresTipos' => $valoresTipos, // Passado para a view
            ]);
        }

        return redirect('/');
    }
}
