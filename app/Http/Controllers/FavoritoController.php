<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favoritos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoritoController extends Controller
{
    public function toggle(Request $request)
    {
        $id_produto = $request->input('id_produto');
        $id_user = Auth::id();

        // Alterado para Favoritos
        $favorito = Favoritos::where('id_user', $id_user)
                            ->where('id_produto', $id_produto)
                            ->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Alterado para Favoritos (plural)
            Favoritos::create([
                'id_user' => $id_user,
                'id_produto' => $id_produto
            ]);
            return response()->json(['status' => 'added']);
        }
    }
}
