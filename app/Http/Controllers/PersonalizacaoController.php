<?php

namespace App\Http\Controllers;

use App\Models\Personalizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Tipo;
use App\Models\todas_as_personalizacoes;
use App\Models\todas_as_respostas;
use App\Models\associadas;
use App\Models\Produto;

class PersonalizacaoController extends Controller
{
    public function index()
    {
        $pesonalizacoes = todas_as_personalizacoes::select('id', 'titulo')->get();
        $selecionadas = todas_as_respostas::select('id', 'resposta')->get();
        $historico = Personalizacao::whereHas('pedido', function ($query) {
            $query->where('id_user', Auth::id()); 
        })
        ->with('produto') 
        ->latest()
        ->get();

        return view('historico_personalizacoes', compact('historico', 'selecionadas', 'pesonalizacoes'));
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
    }
    
    public function create()
    {
        $tipo    = Tipo::all();
        $todas_personalizações = todas_as_personalizacoes::all();
        
        return view('produto.categoria.personalizacoes.criar_personalizacoes', compact( 'tipo', 'todas_personalizações'));
    }

    public function store(Request $request)
    {
        $request->validate([
        'nome' => 'required|string|max:255',    
        'descricao' => 'required|string|max:255',
        'pdf' => 'nullable|file|mimetypes:application/pdf',
        'tipo_de_input' => 'required|in:texto,select,checkbox',
        'campos' => 'nullable|array',     // Recebe os inputs do select/checkbox
        'campos.*' => 'nullable|string|max:255',   // Cada opção
    ]);

        $personalizacao = new todas_as_personalizacoes();
        $personalizacao->titulo = $request->nome;
        $personalizacao->descricao = $request->descricao;
        $personalizacao->tipo_de_input = $request->tipo_de_input;

        if ($request->hasFile('pdf')) {
            $personalizacao->pdf = $request->file('pdf')->store('pdfs', 'public');
        }

        $personalizacao->save();

        // Guardar opções se forem select ou checkbox
        if (in_array($request->tipo_de_input, ['select', 'checkbox']) && $request->filled('campos')) {
        foreach ($request->campos as $opcao) {
            $personalizacao->respostas()->create([
                'resposta' => $opcao,
                ]);
            }
        }


        return redirect()
            ->route('categoria.criar')
            ->with('success', 'Personalização criada com sucesso!');
        }


    public function tabelaPedidos()
    {
        $pedidos = Pedido::all();
        $users = \App\Models\User::all();
        return view('admin.tabela_pedidos', compact('pedidos', 'users'));
    }
    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:não visto,visto,a trabalhar,concluido',
        ]);

        $pedido = pedido::findOrFail($id);
        $pedido->estado = $request->estado;
        $pedido->save();

        return response()->json(['success' => true]);
    }
    public function delete($id)
    {
        $pedido = Pedido::findOrFail($id);

            
            // Apagamos as personalizações primeiro (importante!)
            \App\Models\Personalizacao::where('id_pedido', $id)->delete();
            
            // Apagamos o pedido
            $pedido->delete();

            return back()->with('success', 'Pedido eliminado com sucesso!');

    }
    public function destroyPersonalizacao(Request $request)
    {
        // Garante que temos um array de IDs como inteiros
        $ids = array_map('intval', $request->personalizacoes ?? []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Nenhuma personalização selecionada.');
        }

        // Busca os registos correspondentes
        $personalizacoes = todas_as_personalizacoes::whereIn('id', $ids)->get();


        if ($personalizacoes->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhuma personalização encontrada para os IDs fornecidos.');
        }

        $personalizacoes->each->delete();
        

        return redirect()->back()->with('success', 'Personalizações eliminadas com sucesso.');
    }
    public function show($id,Request $request)
    {


    return view('produto.categoria.personalizacoes.show');
        
    }
    
}