<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Tipo;
use App\Models\TodasAsPersonalizacoes;
use App\Models\TodasAsRespostas;
use App\Models\Associadas;

class CategoriaController extends Controller
{
    public function create()
{
    $tipo = Tipo::all();
    $todas_personalizacoes = TodasAsPersonalizacoes::all();

    return view('categoria.criar_categoria', compact('tipo', 'todas_personalizacoes'));
}
    public function store(Request $request)
    {
        $request->validate([
            'Categoria' => 'required|string|max:255',
        ]);

        $categoria = new Tipo();
        $categoria->categoria = $request->input('Categoria');
        $categoria->save();

        foreach ($request->input('personalizacoes', []) as $idPersonalizacao) {
            $associada = new Associadas();
            $associada->id_tipo  = $categoria->id;
            $associada->id_todas = $idPersonalizacao;
            $associada->save();
        }

        return redirect()->route('dashboard')->with('success', 'Categoria criada com sucesso!');
    }
    public function edit($id)
    {
        $categoria = Tipo::findOrFail($id);

        $todas_personalizacoes = TodasAsPersonalizacoes::all();

        $associados = Associadas::where('id_tipo', $categoria->id)->get();

        return view('categoria.editar_categoria', compact('categoria', 'todas_personalizacoes', 'associados'));
    }
    public function update(Request $request, $id)
    {
        $categoria = Tipo::findOrFail($id);

        $request->validate([
            'Categoria' => 'required|string|max:255',
        ]);

        // atualizar nome da categoria
        $categoria->categoria = $request->input('Categoria');
        $categoria->save();


        // PERSONALIZAÇÕES ANTIGAS
        $antigasPersonalizacoes = Associadas::where('id_tipo', $categoria->id)
            ->pluck('id_todas')
            ->toArray();

        // PERSONALIZAÇÕES NOVAS
        $novasPersonalizacoes = $request->input('personalizacoes', []);

        // descobrir quais foram removidas
        $removidas = array_diff($antigasPersonalizacoes, $novasPersonalizacoes);


        // remover personalizações dos produtos se necessário
        if (!empty($removidas)) {

            $produtos = Produto::where('tipo_prod', $categoria->id)->get();

            foreach ($produtos as $produto) {

                $opcoes = json_decode($produto->personalizar_opcoes, true) ?? [];

                $opcoes = array_diff($opcoes, $removidas);

                $produto->personalizar_opcoes = json_encode(array_values($opcoes));
                $produto->save();
            }
        }


        // atualizar tabela associadas
        Associadas::where('id_tipo', $categoria->id)->delete();

        foreach ($novasPersonalizacoes as $idPersonalizacao) {
            Associadas::create([
                'id_tipo' => $categoria->id,
                'id_todas' => $idPersonalizacao
            ]);
        }


        return redirect()->route('dashboard')
            ->with('success', 'Categoria atualizada com sucesso!');
    }
    public function destroy($id)
    {
        $categoria = Tipo::findOrFail($id);
        $produtos = Produto::where('tipo_prod', $categoria->id)->get();

        if($produtos->count() > 0) {

            return redirect()->route('dashboard')
                ->withErrors(['categoria' => 'Não é possível apagar esta categoria, pois existem produtos associados a ela.']);
        }

        $categoria->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Categoria eliminada com sucesso!');
    }
}
