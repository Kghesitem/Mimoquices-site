<?php

namespace App\Http\Controllers;

use App\Models\Personalizacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pedido;
use App\Models\Tipo;
use App\Models\Todas_as_personalizacoes;
use App\Models\Todas_as_respostas;
use App\Models\Associadas;
use App\Models\Produto;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PersonalizacaoController extends Controller
{
    public function index()
    {
        $pesonalizacoes = Todas_as_personalizacoes::select('id', 'titulo')->get();
        $selecionadas = Todas_as_respostas::select('id', 'resposta')->get();
        $historico = Personalizacao::whereHas('pedido', function ($query) {
            $query->where('id_user', Auth::id()); 
        })
        ->with('produto') 
        ->latest()
        ->get();

        return view('personalizacoes.historico_personalizacoes', compact('historico', 'selecionadas', 'pesonalizacoes'));
    }

    public function destroy($id)
    {
        $pedido = Pedido::findOrFail($id);

        if ($pedido->id_user !== auth()->id()) {
            return back()->with('error', 'Não tens permissão para isto.');
        }

        $estadoAtual = mb_strtolower(trim($pedido->estado));

        if ($estadoAtual === 'não visto' || $estadoAtual === 'pendente') {
            Personalizacao::where('id_pedido', $id)->delete();
            $pedido->delete();

            return back()->with('success', 'Pedido eliminado com sucesso!');
        }

        return back()->with('error', 'Não foi possível eliminar. O estado atual é: "' . $pedido->estado . '"');
    }
    
    public function create()
    {
        $tipo = Tipo::all();
        $todas_personalizações = todas_as_personalizacoes::all();
        
        return view('personalizacoes.criar_personalizacoes', compact('tipo', 'todas_personalizações'));
    }

    public function store(Request $request)
    {
        // Ajustado para mimes:pdf para bater certo com o update
        $request->validate([
            'nome'          => 'required|string|max:255',    
            'descricao'     => 'required|string|max:255',
            'pdf'           => 'nullable|file|mimes:pdf|max:5120',
            'tipo_de_input' => 'required|in:texto,select,checkbox',
            'campos'        => 'nullable|array',    
            'campos.*'      => 'nullable|string|max:255',   
        ]);

        $caminhoPdf = null;
        if ($request->hasFile('pdf') && $request->file('pdf')->isValid()) {
            $caminhoPdf = $request->file('pdf')->store('pdfs', 'public');
        }

        // Criar usando DB para manter a consistência com a tabela real da migração
        $idPersonalizacao = DB::table('todas_as_personalizacoes')->insertGetId([
            'titulo'        => $request->nome,
            'descricao'     => $request->descricao,
            'tipo_de_input' => $request->tipo_de_input,
            'PDF'           => $caminhoPdf,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        // Guardar opções se forem select ou checkbox na tabela 'respostas'
        if (in_array($request->tipo_de_input, ['select', 'checkbox']) && $request->has('campos')) {
            foreach ($request->campos as $opcao) {
                if (!is_null($opcao) && trim($opcao) !== '') {
                    DB::table('respostas')->insert([
                        'id_personalizacao' => $idPersonalizacao,
                        'resposta'          => trim($opcao),
                        'created_at'        => now(),
                        'updated_at'        => now()
                    ]);
                }
            }
        }

        return redirect()
            ->route('categoria.criar')
            ->with('success', 'Personalização criada com sucesso!');
    }

    // Antes: public function edit(Request $request)
    public function edit($id) 
    {
        // Agora o $id vai receber o número "1" diretamente da URL
        $personalizacao = Todas_as_personalizacoes::findOrFail($id);
        $respostas = Todas_as_respostas::where('id_personalizacao', $id)->get();

        return view('personalizacoes.editar_personalizacoes', compact('personalizacao', 'respostas'));
    }
    public function update(Request $request, $id)
{
    // 1. Garante que a personalização existe antes de continuar
    $personalizacao = Todas_as_personalizacoes::findOrFail($id);

    // 2. Validação dos dados recebidos do formulário
    $request->validate([
        'nome'          => 'required|string|max:255',    
        'descricao'     => 'required|string|max:255',
        'tipo_de_input' => 'required|in:texto,select,checkbox',
        'campos'        => 'nullable|array',    
        'campos.*'      => 'nullable|string|max:255',   
    ]);

    // 3. Atualiza os dados principais da personalização
    $personalizacao->titulo = $request->nome;
    $personalizacao->descricao = $request->descricao;
    $personalizacao->tipo_de_input = $request->tipo_de_input;
    $personalizacao->save();

    // 4. Sincroniza as opções (respostas) na base de dados
    if (in_array($request->tipo_de_input, ['select', 'checkbox'])) {
        
        // Remove as opções antigas para evitar duplicados
        Todas_as_respostas::where('id_personalizacao', $id)->delete();
        
        // Insere as novas opções enviadas pelo formulário
        if ($request->has('campos')) {
            foreach ($request->campos as $opcao) {
                if (!is_null($opcao) && trim($opcao) !== '') {
                    // Usando o Model em vez de DB::table para manter o padrão do Laravel
                    Todas_as_respostas::create([
                        'id_personalizacao' => $id,
                        'resposta'          => trim($opcao),
                    ]);
                }
            }
        }
    } else {
        // Se mudou o tipo para 'texto', limpa qualquer opção que existisse antes
        Todas_as_respostas::where('id_personalizacao', $id)->delete();
    }

    // 5. Redireciona o utilizador com uma mensagem de sucesso
    // Certifique-se de que a rota 'categoria.criar' ou outra de listagem existe no seu web.php
    return redirect()
        ->route('categoria.criar') 
        ->with('success', 'Personalização atualizada com sucesso!');
}

    public function tabelaPedidos()
    {
        $pedidos_g = Pedido::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->orderBy('total', 'desc')
            ->take(15)
            ->get();

        $labels = $pedidos_g->pluck('estado');
        $valores = $pedidos_g->pluck('total');

        $pedidosData = Personalizacao::select('id_produto', DB::raw('count(DISTINCT id_pedido) as total'))
            ->with('produto')
            ->groupBy('id_produto')
            ->orderBy('total', 'desc')
            ->take(15)
            ->get();

        $labelsPedidos = $pedidosData->map(fn($p) => $p->produto->titulo ?? 'Desconhecido');
        $valoresPedidos = $pedidosData->pluck('total');

        $pedidos = Pedido::all();
        $users = \App\Models\User::all();
        
        return view('admin.tabela_pedidos', compact(
            'pedidos', 
            'users', 
            'labels', 
            'valores', 
            'labelsPedidos', 
            'valoresPedidos'
        ));
    }

    public function atualizar(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:não visto,visto,a trabalhar,concluido',
        ]);

        $pedido = Pedido::findOrFail($id);
        $pedido->estado = $request->estado;
        $pedido->save();

        return response()->json(['success' => true]);
    }

    public function delete($id)
    {
        $pedido = Pedido::findOrFail($id);
        
        Personalizacao::where('id_pedido', $id)->delete();
        $pedido->delete();

        return back()->with('success', 'Pedido eliminado com sucesso!');
    }

    public function destroyPersonalizacao(Request $request)
    {
        $ids = array_map('intval', $request->personalizacoes ?? []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Nenhuma personalização selecionada.');
        }

        // Removidas também as respostas vinculadas a estas personalizações para não deixar lixo na BD
        DB::table('respostas')->whereIn('id_personalizacao', $ids)->delete();
        DB::table('todas_as_personalizacoes')->whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Personalizações eliminadas com sucesso.');
    }

    public function show($id, Request $request)
    {
        $pedido = Pedido::findOrFail($id);
        $historico = Personalizacao::with('pedido', 'produto')
            ->where('id_pedido', $id)
            ->get();

        if ($pedido->estado == 'não visto') {
            $pedido->update(['estado' => 'visto']);
        }

        $pesonalizacoes = Todas_as_personalizacoes::select('id', 'titulo')->get();
        $selecionadas = Todas_as_respostas::select('id', 'resposta')->get();

        return view('personalizacoes.show', compact('pedido', 'historico', 'selecionadas', 'pesonalizacoes'));
    }
}