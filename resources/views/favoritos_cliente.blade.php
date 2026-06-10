@include('partial/header')
<head>
    <title>Produtos - Mimoquices</title>
</head>

{{-- Banner --}}
    <div class="banner">
        <img class="banner" src="frontend/assets/img/BannerPapelaria.png" alt="">
    </div>
{{-- ------ --}}

{{--Produtos Favoritados pelo cliente --}}
    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <h1 class="mb-4">Favoritos</h1>
            @if($produtos->isEmpty()) {{-- Verificar se a coleção de produtos está vazia --}}
                    <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
                        Nenhum Favorito Encontrado.
                    </div>
                @else

            {{-- LISTA DE PRODUTOS --}}
            <div class="limite">
                @foreach($produtos as $produto)
                    <a href="{{ route('produto.show', $produto->url_completo) }}"
                    class="produtos-produto animacao-aparecer text-decoration-none"
                    data-tipo="{{ $produto->tipo_prod }}" data-destaque="{{ $produto->destaque }}" data-produto-id="{{ $produto->id }}">
                    <x-heroicon-c-heart
                            class="favorite-btn {{ in_array($produto->id, $favoritos) ? 'active' : '' }}"
                            aria-label="Favoritar"
                        />

                        <div>
                            <img class="produto-img" src="{{ asset('storage/' . $produto->nome_cod) }}" alt="Produto: {{ $produto->titulo ?? $produto->nome_original ?? 'Mimoquices' }}">
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
{{-- -------------------------------- --}}

<script src="{{ asset('frontend/assets/js/favoritos.js') }}"></script>
@include('partial/footer')
</body>
</html>
