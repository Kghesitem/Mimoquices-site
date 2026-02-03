<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Tipo;
use App\Models\Fotos;
use App\Models\Personalizacao;
use App\Models\Pedido;
use App\Mail\PersonalizarMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all()->where('disponivel', 1);
        $tipos = Tipo::all();

        return view('produto.index', [
            'produtos' => $produtos,
            'tipos' => $tipos,
        ]);
    }

    public function welcome()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->where('disponivel', 1)->take(8)->get();
        $tipos = Tipo::all();

        return view('welcome', [
            'produtos' => $produtos,
            'tipos' => $tipos,
        ]);
    }

    public function show($url_completo)
    {
        $produto = Produto::where('url_completo', $url_completo)->where('disponivel', 1)->firstOrFail();
        $tipo    = Tipo::find($produto->tipo_prod);
        $fotos = Fotos::where('group_img', $produto->id)
        ->select('img_original', 'img_cod')
        ->get();


        return view('produto.show', compact('produto', 'tipo', 'fotos'));

    }

    public function create()
    {
        $tipos = Tipo::all();

        return view('produto.criar', [
            'tipos' => $tipos
        ]);
    }
    
    public function store(Request $request)
    {
        $produtos = Produto::all();
        // Para testes
        // dd($request);

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
    // 1️⃣ Obter o produto
    $produto = Produto::where('url_completo', $url_completo)->firstOrFail();
    $opcoesDisponiveis = json_decode($produto->personalizar_opcoes ?? '[]', true);

    // 2️⃣ Criar o pedido
    $pedido = Pedido::create([
        'id_user' => auth()->id(),
        'estado' => 'pendente',
    ]);

    // 3️⃣ Preparar campos possíveis
    $campos = [
        'texto_capa',
        'formato_agenda',
        'acessorio',
        'paginas_especiais',
        'cor_argolas',
        'tipo_de_chocolate',
        'nome_embalagem'
    ];

    $rules = [];

    if (in_array('texto_capa', $opcoesDisponiveis)) {
        $rules['texto_capa'] = ['required', 'string', 'max:30'];
    }

    if (in_array('formato_agenda', $opcoesDisponiveis)) {
        $rules['formato_agenda'] = ['required', 'in:Com horas,Sem horas'];
    }

    if (in_array('acessorio', $opcoesDisponiveis)) {
        $rules['acessorio'] = ['required', 'in:Metálico,Acrílico'];
    }

    if (in_array('paginas_especiais', $opcoesDisponiveis)) {
        $rules['paginas_especiais'] = ['array'];
    }

    if (in_array('cor_argolas', $opcoesDisponiveis)) {
        $rules['cor_argolas'] = ['required', 'in:Prata,Ouro,Preto,Rose Gold,Cobre'];
    }

    if (in_array('tipo_de_chocolate', $opcoesDisponiveis)) {
        $rules['tipo_de_chocolate'] = ['required', 'in:Chocolate negro,Chocolate branco,Chocolate com leite'];
    }

    if (in_array('nome_embalagem', $opcoesDisponiveis)) {
        $rules['nome_embalagem'] = ['required', 'string', 'max:30'];
    }

    $request->validate($rules);

    // 5️⃣ Criar personalizações
    $personalizacoes = [];

    foreach ($campos as $campo) {
        if (!$request->filled($campo)) continue;

        $valor = $request->input($campo);
        if (is_array($valor)) {
            $valor = implode(', ', $valor);
        }

        $personalizacao = Personalizacao::create([
            'personalizacao_pedida' => $campo,
            'opcoes_selecionadas' => $valor,
            'id_produto' => $produto->id,
            'id_pedido' => $pedido->id,
        ]);

        $personalizacoes[] = $personalizacao;
    }

    // 6️⃣ Enviar email em background (queue)
    Mail::to(auth()->user()->email)->queue(
        new PersonalizarMail($produto, $personalizacoes)
    );

    // 7️⃣ Redirecionar de volta
    return redirect()
        ->route('produto.show', $url_completo)
        ->with('success', 'Produto personalizado com sucesso!');
}


}
?>