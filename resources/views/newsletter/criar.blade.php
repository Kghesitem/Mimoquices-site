<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Newsletter - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial.header')

<main style="padding: 1rem 1rem;">
<div class="auth-container auth-container-full">

    {{-- Botão Voltar --}}
    <div class="d-flex justify-content-center" style="margin-bottom: 1.5rem;">
        <a class="btn botao-voltar text-decoration-none d-inline-flex align-items-center" href="{{ url('/dashboard') }}" style="gap: 0.5rem;">
            ← Voltar para o Dashboard
        </a>
    </div>

    {{-- CABEÇALHO DO FORMULÁRIO --}}
    <div class="auth-header rounded" style="text-align: left; margin-bottom: 2.5rem;">
        <h1>
            <x-heroicon-s-envelope style="width: 2.5rem; height: 2.5rem; vertical-align: middle; color: white;"/>
            Criar Nova Newsletter
        </h1>
        <p style="text-align: center;">Filtra e seleciona os produtos que queres incluir nesta campanha de e-mail</p>
    </div>

    {{-- ERROS --}}
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Erro!',
                    html: "{!! implode('<br>', array_map('e', $errors->all())) !!}",
                    icon: 'error',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    {{-- FORMULÁRIO --}}
    <form method="POST" action="{{ route('newsletter.enviar') }}" class="auth-form" style="max-width: 100%;">
        @csrf

        {{-- BARRA DE FILTROS (Igual à página de produtos pública) --}}
        <div class="p-3 mb-4 rounded d-flex flex-wrap align-items-center gap-3" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
            <div class="d-flex align-items-center gap-2">
                <label for="pesquisa" class="fw-bold mb-0 small" style="color: #4a5568;">Pesquisa:</label>
                <input type="text" placeholder="Ex: Caderno" id="pesquisa" class="form-control form-control-sm d-inline-block w-auto">
            </div>

            <div class="d-flex align-items-center gap-2">
                <label for="filtroTipos" class="fw-bold mb-0 small" style="color: #4a5568;">Categoria:</label>
                <select id="filtroTipos" class="form-select form-select-sm d-inline-block w-auto">
                    <option value="">Todas</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->Categoria }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex align-items-center gap-2">
                <label for="ordenar" class="fw-bold mb-0 small" style="color: #4a5568;">Ordenar:</label>
                <select id="ordenar" class="form-select form-select-sm d-inline-block w-auto">
                    <option value="nome_asc">Nome A→Z</option>
                    <option value="nome_desc">Nome Z→A</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 1.5rem;">
            {{-- Corrigido: Adicionado o atributo for associado ao id do textarea --}}
            <label for="newsletter_text" class="form-label" style="font-weight: bold; display: block; margin-bottom: 0.75rem;">
                Mensagem da Newsletter:
            </label>

            <textarea name="newsletter_text" id="newsletter_text" rows="5" class="form-control" placeholder="Escreve uma mensagem personalizada para os teus clientes..." style="width: 100%; min-height: 150px; padding: 0.85rem; border: 1px solid #ddd; border-radius: 0.5rem; resize: vertical; font-family: inherit;">{{ old('newsletter_text') }}</textarea>

            @error('newsletter_text')
                <p class="text-danger" style="font-size:0.9rem; margin-top:0.5rem;">{{ $message }}</p>
            @enderror

            <small class="text-muted" style="font-size: 0.85rem; display: block; margin-top: 0.5rem;">
                Este texto aparecerá no início do e-mail, antes dos produtos.
            </small>
        </div>

        <fieldset class="form-group" style="border: none; padding: 0; margin: 0;">

            {{-- Corrigido: A label passa a ser uma legend, ideal para títulos de grupos --}}
            <legend class="form-label" style="font-weight: bold; margin-bottom: 1rem; display: block; width: 100%; float: left;">
                Selecione os produtos pretendidos:
            </legend>

            {{-- Zona de Scroll para os cards dos produtos --}}
            <div style="clear: both; max-height: 480px; overflow-y: auto; padding-right: 10px; border: 1px solid #eee; border-radius: 0.5rem; padding: 1rem; background: #fafafa;">

                <div id="produtosContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">

                    @foreach($produtos as $produto)
                        <div class="opcao-item produto-card-filter" data-tipo="{{ $produto->tipo_prod }}" style="display: flex; gap: 0.75rem; align-items: center; padding: 0.75rem; border: 1px solid #ddd; border-radius: 0.5rem; background: #fff; transition: transform 0.2s, box-shadow 0.2s;">

                            <input type="checkbox"
                                   name="produtos_ids[]"
                                   value="{{ $produto->id }}"
                                   id="prod_{{ $produto->id }}"
                                   class="form-checkbox"
                                   style="width: 1.25rem; height: 1.25rem; cursor: pointer;">

                            @if($produto->nome_cod)
                                <div style="width: 55px; height: 55px; overflow: hidden; border-radius: 0.35rem; border: 1px solid #eee; flex-shrink: 0;">
                                    <img src="{{ asset('storage/' . $produto->nome_cod) }}" alt="Produto: {{ $produto->titulo ?? $produto->nome_original ?? 'Mimoquices' }}" class="produto-img" loading="lazy">
                                </div>
                            @endif


                            <label for="prod_{{ $produto->id }}" class="form-label-checkbox" style="cursor: pointer; user-select: none; flex-grow: 1; margin: 0;">
                                <strong class="d-block" style="color: #2d3748; font-size: 0.95rem; line-height: 1.3;">{{ $produto->titulo }}</strong>
                                <span class="text-muted small" style="font-size: 0.8rem;">ID: {{ $produto->id }}</span>
                            </label>
                        </div>
                    @endforeach

                     <p id="semProdutos" class="text-center fw-bold mt-4 py-3 text-muted" style="display:none; font-style: italic;">
                                Nenhum produto corresponde aos filtros aplicados.
                    </p>

                </div>
            </div>
        </fieldset>

        {{-- BOTÃO SUBMIT --}}
        <div class="grid-full-width">
            <button type="submit" class="btn-submit" style="margin-top: 2rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onclick="this.disabled=true; this.form.submit();">
                🚀 Enviar Newsletter para os Clientes
            </button>
        </div>
    </form>

    {{-- RODAPÉ --}}
    <div class="auth-footer" style="margin-top: 3rem;">
        <p>Queres verificar os produtos no inventário primeiro?</p>
        <a href="{{ url('/dashboard') }}">Voltar à Lista de Produtos →</a>
    </div>

</div>
</main>

@include('partial.footer')


<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.produto-img').forEach(img => {
            if (img.complete) {
                img.classList.add('is-loaded');
            } else {
                img.addEventListener('load', () => {
                    img.classList.add('is-loaded');
                });
            }
        });
        // =========================================================================

        const filtroTipos = document.getElementById('filtroTipos');
        const pesquisa = document.getElementById('pesquisa');
        const ordenar = document.getElementById('ordenar');
        const produtosContainer = document.getElementById('produtosContainer');
        const produtos = Array.from(document.querySelectorAll('.produto-card-filter'));
        const semProdutos = document.getElementById('semProdutos');

        function atualizarProdutos(){
            if (!produtos.length) return;

            const tipo = filtroTipos ? filtroTipos.value : '';
            const texto = pesquisa ? pesquisa.value.trim().toLowerCase() : '';

            let encontrou = false;

            produtos.forEach(prod => {
                const tituloEl = prod.querySelector('strong');
                const titulo = tituloEl ? tituloEl.textContent.trim().toLowerCase() : '';

                const matchTipo = (tipo === '' || prod.dataset.tipo === tipo);
                const matchTexto = (texto === '' || titulo.includes(texto));

                if (matchTipo && matchTexto) {
                    prod.style.setProperty('display', 'flex', 'important');
                    encontrou = true;
                } else {
                    prod.style.setProperty('display', 'none', 'important');
                }
            });

            if (semProdutos) semProdutos.style.display = encontrou ? 'none' : 'block';

            // Ordenação em tempo real dentro do contêiner da Newsletter
            if (ordenar && produtosContainer) {
                const ord = ordenar.value;
                const visiveis = produtos.filter(p => p.style.display !== 'none');

                visiveis.sort((a, b) => {
                    const A = (a.querySelector('strong')?.textContent || '').toLowerCase();
                    const B = (b.querySelector('strong')?.textContent || '').toLowerCase();
                    return ord === 'nome_asc' ? A.localeCompare(B) : B.localeCompare(A);
                });

                visiveis.forEach(p => produtosContainer.appendChild(p));
            }
        }

        if (filtroTipos) filtroTipos.addEventListener('change', atualizarProdutos);
        if (pesquisa) pesquisa.addEventListener('input', atualizarProdutos);
        if (ordenar) ordenar.addEventListener('change', atualizarProdutos);

        // Executa uma vez ao carregar para aplicar definições iniciais
        atualizarProdutos();
    });
</script>

</body>
</html>
