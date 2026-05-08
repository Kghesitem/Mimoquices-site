@include('partial/header')
<head>
    <title>Produtos - Mimoquices</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>

    <div class="banner">
        <img class="banner" src="frontend/assets/img/BannerPapelaria.png" alt="">
    </div>

    <div class="centrador">
        <div class="filtro">

            <label class="ms-3">Pesquisa:</label>
            <input type="text" placeholder="Caderno" id="pesquisa" class="form-control d-inline-block w-auto ms-2">

            <!-- SELECT PARA FILTRO -->
             <label class="ms-3">Categoria:</label>
            <select id="filtroTipos" class="form-select d-inline-block w-auto">
                <option value="">Todos</option>
                @foreach($tipos as $tipo)
                    <option value="{{$tipo->id}}">{{$tipo->Categoria}}</option>
                @endforeach
            </select>

            <label class="ms-3">Ordenar:</label>
            <select id="ordenar" class="form-select d-inline-block w-auto ms-2">
                <option value="nome_asc">Nome A→Z</option>
                <option value="nome_desc">Nome Z→A</option>
            </select>

             <label class="ms-3">destaques:</label>
            <select id="destaques" class="form-select d-inline-block w-auto ms-2">
                <option value="">destaques e não destaques</option>
                <option value="1">destaques</option>
                <option value="0">Não destaques</option>
            </select>
        </div>
    </div>


<div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
    <div class="container">
        <h1 class="mb-4">Produtos</h1>
        @if($produtos->isEmpty())
                <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
                    Nenhum produto encontrado.
                </div>
            @else

        <!-- LISTA DE PRODUTOS -->
        <div class="limite">
            @foreach($produtos as $produto)
                <a href="/produtos/{{$produto->url_completo}}" 
                   class="produtos-produto animacao-aparecer text-decoration-none" 
                   data-tipo="{{ $produto->tipo_prod }}" data-destaque="{{ $produto->destaque }}" data-produto-id="{{ $produto->id }}">
                   <x-heroicon-c-heart 
                        class="favorite-btn {{ in_array($produto->id, $favoritos) ? 'active' : '' }}" 
                        aria-label="Favoritar"
                    />
                    <div>
                        <img class="produto-img" 
                             src="{{asset("Storage/{$produto->nome_cod}")}}" 
                             alt="{{$produto->nome_original}}">
                    </div>

                    <div>
                        <h3>{{$produto->titulo}}</h3> 
                    </div>

                    <div>
                        @foreach ($tipos as $tipo)
                            @if ($produto->tipo_prod == $tipo->id)
                                {{$tipo->Categoria}}
                            @endif
                        @endforeach
                    </div>
                </a>
            @endforeach
            @endif
        </div>

        <p id="semProdutos" class="text-center fw-bold mt-4" style="display:none;">
            Nenhum produto encontrado.
        </p>
    </div>
</div>

@include('partial/footer')

<script>

document.addEventListener('DOMContentLoaded', function(){
    const filtroTipos = document.getElementById('filtroTipos');
    const pesquisa = document.getElementById('pesquisa');
    const ordenar = document.getElementById('ordenar');
    const destaques = document.getElementById('destaques');
    const produtosContainer = document.querySelector('.limite');
    const produtos = Array.from(document.querySelectorAll('.produtos-produto'));
    const semProdutos = document.getElementById('semProdutos');

    const params = new URLSearchParams(window.location.search);
    const tipoParam = params.get('tipo');
    if (tipoParam && filtroTipos) filtroTipos.value = tipoParam;

    function atualizarProdutos(){
        if (!produtos.length) return;

        const tipo = filtroTipos ? filtroTipos.value : '';
        const texto = pesquisa ? pesquisa.value.trim().toLowerCase() : '';
        const favValue = destaques ? destaques.value : '';
        
        let encontrou = false;

        produtos.forEach(prod => {
            const tituloEl = prod.querySelector('h3');
            const titulo = tituloEl ? tituloEl.textContent.trim().toLowerCase() : '';
            
            const matchTipo = (tipo === '' || prod.dataset.tipo === tipo);
            
            const matchTexto = (texto === '' || titulo.includes(texto));
            
            const matchdestaque = (favValue === '' || prod.dataset.destaque === favValue);
            
            prod.style.display = (matchTipo && matchTexto && matchdestaque) ? '' : 'none';
            if (matchTipo && matchTexto && matchdestaque) encontrou = true;
        });

        if (semProdutos) semProdutos.style.display = encontrou ? 'none' : 'block';

        // Ordenar apenas os visíveis
        if (ordenar && produtosContainer) {
            const ord = ordenar.value;
            const visiveis = produtos.filter(p => p.style.display !== 'none');
            visiveis.sort((a,b) => {
                const A = (a.querySelector('h3')?.textContent || '').toLowerCase();
                const B = (b.querySelector('h3')?.textContent || '').toLowerCase();
                return ord === 'nome_asc' ? A.localeCompare(B) : B.localeCompare(A);
            });
            visiveis.forEach(p => produtosContainer.appendChild(p));
        }
    }

    if (filtroTipos) filtroTipos.addEventListener('change', atualizarProdutos);
    if (pesquisa) pesquisa.addEventListener('input', atualizarProdutos);
    if (ordenar) ordenar.addEventListener('change', atualizarProdutos);
    if (destaques) destaques.addEventListener('change', atualizarProdutos);

    atualizarProdutos();
});
</script>
<script src="{{ asset('frontend/assets/javascript/favoritos.js') }}"></script>
</body>
</html>