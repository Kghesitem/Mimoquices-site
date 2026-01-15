<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Tipo;
use App\Models\Fotos;
use Illuminate\Support\Str;

class ProdutoController extends Controller
{
    public function index()
    {
        $produtos = Produto::all();
        $tipos = Tipo::all();

        return view('produto.index', [
            'produtos' => $produtos,
            'tipos' => $tipos,
        ]);
    }

    public function welcome()
    {
        $produtos = Produto::orderBy('created_at', 'desc')->take(8)->get();
        $tipos = Tipo::all();

        return view('welcome', [
            'produtos' => $produtos,
            'tipos' => $tipos,
        ]);
    }

    public function show($url_completo)
    {
        $produto = Produto::where('url_completo', $url_completo)->firstOrFail();
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
            'url_completo' => ['nullable'],
            'tipo_prod' => ['required'],
            'nome_original' => ['required', 'array', 'min:1'],
            'nome_original.*' => ['image'],
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

        $data['url_completo'] = rand(0, 10) . "-" . $data['titulo'];
        $novoproduto = Produto::create($data);



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
}
?>