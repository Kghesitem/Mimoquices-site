<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Tipo;
use App\Models\Fotos;
use App\Models\favoritos;
use App\Models\Personalizacao;
use App\Models\todas_as_personalizacoes;
use App\Models\associadas;
Use App\Models\todas_as_respostas;
use App\Models\Pedido;
use App\Mail\PersonalizarMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function index()
    {
        // Filtragem feita diretamente na BD para melhor performance
        $produtos = Produto::where('disponivel', 1)->get();
        $tipos = Tipo::all();
        
        // Verifica favoritos apenas se o utilizador estiver logado
        $favoritos = Auth::check() 
            ? favoritos::where('id_user', Auth::id())->pluck('id_produto')->toArray() 
            : [];

        return view('produto.index', [
            'produtos' => $produtos,
            'tipos' => $tipos,
            'favoritos' => $favoritos
        ]);
    }

    public function welcome()
    {
        $produtos = Produto::orderBy('created_at', 'desc')
            ->where('disponivel', 1)
            ->take(8)
            ->get();

        $destaques = Produto::where('disponivel', 1)
            ->where('destaque', 1)
            ->get();

        $tipos = Tipo::all();

        $favoritos = Auth::check() 
            ? favoritos::where('id_user', Auth::id())->pluck('id_produto')->toArray() 
            : [];

        return view('welcome', [
            'produtos' => $produtos,
            'tipos' => $tipos,
            'destaques' => $destaques,
            'favoritos' => $favoritos
        ]);
    }

    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $id_produto = $request->input('id_produto');
        $id_user = Auth::id();

        // Procura se o favorito já existe para este utilizador
        $favorito = favoritos::where('id_user', $id_user)
                            ->where('id_produto', $id_produto)
                            ->first();

        if ($favorito) {
            // Se já existe, remove (Unfavorite)
            $favorito->delete();
            return response()->json(['status' => 'removed']);
        } else {
            // Se não existe, cria (Favorite)
            favoritos::create([
                'id_user' => $id_user,
                'id_produto' => $id_produto
            ]);
            return response()->json(['status' => 'added']);
        }
    }


    public function show($url_completo)
    {
        $produto = Produto::where('url_completo', $url_completo)->where('disponivel', 1)->firstOrFail();
        $tipo    = Tipo::find($produto->tipo_prod);
        $associadas = associadas::where('id_tipo', $tipo->id)->get();
        if($produto->personalizar_opcoes == null)
        {
            $todas_personalizações = null;
            $todas_respostas = null;
        }
        else
        {
            $todas_personalizações = todas_as_personalizacoes::wherein('id', json_decode($produto->personalizar_opcoes))->get();
            $todas_respostas = todas_as_respostas::whereIn('id_personalizacao',$todas_personalizações->pluck('id'))->get();
        }
        
        
        $fotos = Fotos::where('group_img', $produto->id)
        ->select('img_original', 'img_cod')
        ->get();

        return view('produto.show', compact('produto', 'tipo', 'associadas','todas_personalizações', 'todas_respostas', 'fotos'));
    }

    public function create()
    {
       
        $tipos = Tipo::all();
        $todas_personalizações = todas_as_personalizacoes::with('tipos')->get();;

        return view('produto.criar', [
            'tipos' => $tipos,
            'todas_personalizações' => $todas_personalizações
        ]);
        
    }
    
    public function store(Request $request)
    {
        $produtos = Produto::all();
        // Para testes
        //  dd($request);

        $uploaded = $request->file('nome_original') ?: [];

        $data = $request->validate([
            'titulo' => ['required'],
            'descricao' => ['required'],
            'conteudo' => ['nullable'],
            'detalhes' => ['nullable'],
            'url_completo' => ['nullable'],
            'tipo_prod' => ['required'],
            'nome_original' => ['required', 'array', 'min:1'],
            'nome_original.*' => ['image'],
            'pode_personalizar' => ['nullable'],
            'personalizar_opcoes' => ['nullable', 'array'],
        ]);

        if (!empty($uploaded) && isset($uploaded[0]) && $uploaded[0]) {
            $file0 = $uploaded[0];
            $fotos['img_1_original'] = $file0->getClientOriginalName();
            $nomeCod0 = md5(time() . $file0->getClientOriginalName()) . '.' . $file0->extension();
            $caminho0 = $file0->storeAs('uploads', $nomeCod0);

            $data['nome_original'] = $fotos['img_1_original'];
            $data['nome_cod'] = $caminho0;

            $fotos['img_1_cod'] = $caminho0;
        }

        
            $data['pode_personalizar'] = $request->input('pode_personalizar') ?? 'Não';
        $data['personalizar_opcoes'] = $request->input('personalizar_opcoes') 
        ? json_encode($request->input('personalizar_opcoes')) 
        : null;

        $data['url_completo'] = '';
        $novoproduto = Produto::create($data);

        $novoproduto->url_completo = $novoproduto->titulo . '-' . $novoproduto->id;
        $novoproduto->save();


        foreach ($uploaded as $index => $file) {
            if (!$file) continue;
            if ($index === 0) continue;
            
            $i = $index; 
            $fotos["img_original"] = $file->getClientOriginalName();
            $nomeCod = md5(time() . $file->getClientOriginalName()) . '.' . $file->extension();
            $caminho = $file->storeAs('uploads', $nomeCod);
            $fotos["img_cod"] = $caminho;

            $id = Produto::where('nome_cod', $data['nome_cod'])->value('id');
            $fotos['group_img'] = $id;
            $novasfotos = Fotos::create($fotos);
        }

        
        return redirect()->route('produto.index');
    }

    public function personalizarProduto(Request $request, $url_completo)
    {
        // Validar o request
        $data = $request->validate([
            'personalizacoes_opcoes' => ['required', 'array'],
            'personalizacoes_opcoes.*' => ['nullable'],
        ]);

        //  Obter o produto
        $produto = Produto::where('url_completo', $url_completo)->firstOrFail();

        //  Criar pedido
        $pedido = Pedido::create([
            'id_user' => auth()->id(),
            'estado' => 'não visto',
        ]);

        //  Array para o email
        $personalizacoesArray = [];

        // Criar UM ou VÁRIOS registos por personalização
        foreach ($data['personalizacoes_opcoes'] as $idPersonalizacao => $opcaoSelecionada) {

            // ❗ Se não foi escolhida nenhuma opção
            if (empty($opcaoSelecionada)) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'personalizacoes_opcoes.' . $idPersonalizacao =>
                            'Tem de escolher uma opção para esta personalização.'
                    ]);
            }

            // Caso seja múltipla escolha (array)
            if (is_array($opcaoSelecionada)) {

                foreach ($opcaoSelecionada as $opcao) {

                    if (empty($opcao)) {
                        continue; // segurança extra
                    }

                    Personalizacao::create([
                        'id_pedido' => $pedido->id,
                        'id_produto' => $produto->id,
                        'personalizacao_pedida' => $idPersonalizacao,
                        'opcoes_selecionadas' => $opcao,
                    ]);

                    $personalizacoesArray[] = [
                        'personalizacao_pedida' => $idPersonalizacao,
                        'opcoes_selecionadas' => $opcao,
                    ];
                }

            }
            // Caso seja apenas uma opção
            else {

                Personalizacao::create([
                    'id_pedido' => $pedido->id,
                    'id_produto' => $produto->id,
                    'personalizacao_pedida' => $idPersonalizacao,
                    'opcoes_selecionadas' => $opcaoSelecionada,
                ]);

                $personalizacoesArray[] = [
                    'personalizacao_pedida' => $idPersonalizacao,
                    'opcoes_selecionadas' => $opcaoSelecionada,
                ];
            }
        }

        $pesonalizacoes = \App\Models\todas_as_personalizacoes::select('id', 'titulo')->get();
        $selecionadas = \App\Models\todas_as_respostas::select('id', 'resposta')->get();
        
        // Buscamos os itens que acabaste de criar, já com o relacionamento do produto carregado
        $itensDoPedido = \App\Models\Personalizacao::where('id_pedido', $pedido->id)
            ->with('produto')
            ->get();

        // Enviar email (agora com os 4 argumentos que a classe espera)

        Mail::to(auth()->user()->email)->send(
            new PersonalizarMail($pedido, $itensDoPedido, $pesonalizacoes, $selecionadas)
        );

        //  Redirect final
        return redirect()
            ->route('produto.show', $url_completo)
            ->with('success', 'Produto personalizado com sucesso!');
    }

    public function visivel(Request $request, $id)
    {
        $request->validate([
            'disponivel' => 'required|in:0,1',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->disponivel = $request->disponivel;
        $produto->save();

        return response()->json(['success' => true]);
    }

    public function destaque(Request $request, $id)
    {
        $request->validate([
            'destaque' => 'required|in:0,1',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->destaque = $request->destaque;
        $produto->save();

        return response()->json(['success' => true]);
    }
    public function favorito(Request $request, $id)
    {
        $request->validate([
            'favorito' => 'required|in:0,1',
        ]);

        $produto = Produto::findOrFail($id);
        $produto->favorito = $request->favorito;
        $produto->save();

        return response()->json(['success' => true]);
    }

    public function update(Produto $produto, Request $request)
    {
        $data = $request->validate([
            'titulo'              => ['required'],
            'descricao'           => ['required'],
            'conteudo'            => ['nullable'],
            'detalhes'            => ['nullable'],
            'tipo_prod'           => ['required'],
            'pode_personalizar'   => ['nullable'],
            'personalizar_opcoes' => ['nullable', 'array'],
            // Validação das novas imagens
            'nome_original'       => ['nullable', 'array'],
            'nome_original.*'     => ['image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
            // Lista de caminhos para remover (enviados pelo JS)
            'fotos_remover'       => ['nullable', 'array'],
        ]);

        // 1. Lógica para Personalização (Converter array para JSON se necessário)
        if (isset($data['personalizar_opcoes'])) {
            $data['personalizar_opcoes'] = json_encode($data['personalizar_opcoes']);
        }

        // 2. Atualizar os dados básicos do produto
        $produto->update($data);

        // 3. Remover as fotos que o utilizador apagou no front-end
        if ($request->has('fotos_remover')) {
            foreach ($request->fotos_remover as $path) {
                // Apaga o ficheiro físico da pasta storage/app/public/
                Storage::disk('public')->delete($path);
                
                // Apaga o registo na sua tabela de Fotos (ajuste o nome da relação se for diferente)
                $produto->fotos()->where('img_cod', $path)->delete();
            }
        }

        // 4. Guardar as NOVAS fotos
        if ($request->hasFile('nome_original')) {
            foreach ($request->file('nome_original') as $file) {
                $nomeOriginal = $file->getClientOriginalName();
                // Guarda na pasta 'uploads' dentro da pasta 'public'
                $caminho = $file->store('uploads', 'public');

                // Criar registo na tabela de fotos relacionada
                $produto->fotos()->create([
                    'img_original' => $nomeOriginal,
                    'img_cod'      => $caminho,
                ]);
            }
        }

        return redirect()->route('dashboard')->with('success', 'Produto atualizado com sucesso!');
    }

    public function edit(Produto $produto)
    {
        $tipos = Tipo::all();
        $todas_personalizações = todas_as_personalizacoes::with('tipos')->get();
        $fotos = Fotos::where('group_img', $produto->id)
        ->select('img_original', 'img_cod')
        ->get();

        return view('produto.edit', ['produto' => $produto],compact('tipos', 'todas_personalizações','fotos'));
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();

        return redirect()->route('dashboard')->with('success', 'Produto eliminado com sucesso!');
    }

}
?>