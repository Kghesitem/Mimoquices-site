@include('partial/header')

<div class="banner">
        <img class="banner" src="frontend/assets/img/BannerPapelaria.png" alt="">
    </div>
<div class="centrador">
    <div class="filtro">
        <!-- SELECT PARA FILTRO -->
        <select id="filtroTipos" class="form-select d-inline-block w-auto">
            <option value="">Todos</option>
            @foreach($tipos as $tipo)
                <option value="{{$tipo->id}}">{{$tipo->Categoria}}</option>
            @endforeach
        </select>

        <label class="ms-3">Pesquisa:</label>
        <input type="text" placeholder="Caderno" id="pesquisa" class="form-control d-inline-block w-auto ms-2">

        <label class="ms-3">Ordenar:</label>
        <select id="ordenar" class="form-select d-inline-block w-auto ms-2">
            <option value="nome_asc">Nome A→Z</option>
            <option value="nome_desc">Nome Z→A</option>
        </select>
    </div>
</div>


<div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
    <div class="container">
        <h1 class="mb-4">Produtos</h1>

        <!-- LISTA DE PRODUTOS -->
        <div class="limite">
            @foreach($produtos as $produto)
                <a href="/produtos/{{$produto->url_completo}}" 
                   class="produtos-produto animacao-aparecer" 
                   data-tipo="{{ $produto->tipo_prod }}">
                    <div>
                        <img class="produto-img" 
                             src="{{asset("Storage/{$produto->nome_cod}")}}" 
                             alt="{{$produto->nome_original}}">
                    </div>

                    <div>
                        <h3>{{$produto->titulo}}</h3><br>
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
        let encontrou = false;

        produtos.forEach(prod => {
            const tituloEl = prod.querySelector('h3');
            const titulo = tituloEl ? tituloEl.textContent.trim().toLowerCase() : '';
            const matchTipo = (tipo === '' || prod.dataset.tipo === tipo);
            const matchTexto = (texto === '' || titulo.includes(texto));
            prod.style.display = (matchTipo && matchTexto) ? '' : 'none';
            if (matchTipo && matchTexto) encontrou = true;
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

    atualizarProdutos();
});
</script>
</body>
</html>
