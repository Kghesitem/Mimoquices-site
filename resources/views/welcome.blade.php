<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/carrosel.css') }}">
    <title>Mimoquices</title>
</head>
<body>

    {{-- 1. CABEÇALHO: Inclui a barra de navegação/menu global do site --}}
    @include('partial/header')

    {{-- 2. BANNER PRINCIPAL: Imagem de destaque no topo da página inicial --}}
    <div class="banner">
        <img class="banner" src="{{ asset('frontend/assets/img/BannerPapelaria.png') }}" alt="Banner Papelaria Mimoquices">
    </div>

    {{-- 3. SECÇÃO: Últimos Produtos Adicionados --}}
    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <h1 class="mb-4">Últimos Produtos Adicionados:</h1>

            {{-- Verificação: Se a lista de novos produtos estiver vazia --}}
            @if($produtos->isEmpty())
                <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
                    Nenhum produto recentemente adicionado.
                </div>
            @else
                {{-- Carrosel envolvido numa div estrutural para isolar as âncoras dos botões --}}
                <div style="position: relative; width: 100%;">

                    {{-- Botão Esquerdo Nativo --}}
                    <button class="btn-scroll-left" onclick="document.querySelector('.carrosel').scrollBy({left: -300, behavior: 'smooth'})">←</button>

                    <div class="carrosel">
                        @foreach ($produtos as $produto)
                            {{-- Cartão do produto com link para a sua página de detalhe --}}
                            <a href="{{ route('produto.show', $produto->url_completo) }}" data-produto-id="{{ $produto->id }}" class="produtos-produto animacao-home text-decoration-none">
                                <x-heroicon-c-heart
                                    class="favorite-btn {{ in_array($produto->id, $favoritos) ? 'active' : '' }}"
                                    aria-label="Favoritar"
                                />
                                {{-- Imagem do Produto --}}
                                <div class="produto-img-container">
                                    <img src="{{ asset('storage/' . $produto->nome_cod) }}"
                                        alt="{{ $produto->titulo ?? $produto->nome_original }}"
                                        class="produto-img"
                                        loading="lazy">
                                </div>

                                {{-- Título do Produto --}}
                                <div>
                                    <h3>{{ $produto->titulo }}</h3>
                                </div>

                                {{-- Categoria do Produto --}}
                                <div>
                                    @foreach ($tipos as $tipo)
                                        @if ($produto->tipo_prod === $tipo->id)
                                            {{ $tipo->Categoria }}
                                        @endif
                                    @endforeach
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Botão Direito Nativo --}}
                    <button class="btn-scroll-right" onclick="document.querySelector('.carrosel').scrollBy({left: 300, behavior: 'smooth'})">→</button>

                </div>
            @endif
        </div>
    </div>

    {{-- 4. SECÇÃO: Produtos em Destaque --}}
    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <h1 class="mb-4">Produtos em Destaque:</h1>

            {{-- Verificação: Se a lista de destaques estiver vazia --}}
            @if($destaques->isEmpty())
                <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
                    Nenhum produto em destaque encontrado.
                </div>
            @else
                {{-- Grelha/Lista de produtos em destaque --}}
                <div class="limite">
                    @foreach($destaques as $destaque)
                        {{-- Cartão do destaque com link dinâmico --}}
                        <a href="{{ route('produto.show', $destaque->url_completo) }}"
                           class="produtos-produto animacao-aparecer text-decoration-none"
                           data-tipo="{{ $destaque->tipo_prod }}" data-produto-id="{{ $destaque->id }}">

                           <x-heroicon-c-heart
                                class="favorite-btn {{ in_array($destaque->id, $favoritos) ? 'active' : '' }}"
                                aria-label="Favoritar"
                            />

                            {{-- Imagem do Destaque --}}
                            <div class="produto-img-container">
                                <img class="produto-img"
                                    src="{{ asset('storage/' . $destaque->nome_cod) }}"
                                    alt="{{ $destaque->titulo ?? $destaque->nome_original }}"
                                    loading="lazy">
                            </div>

                            {{-- Título do Destaque --}}
                            <div>
                                <h3>{{ $destaque->titulo }}</h3>
                            </div>

                            {{-- Categoria do Destaque --}}
                            <div>
                                @foreach ($tipos as $tipo)
                                    @if ($destaque->tipo_prod == $tipo->id)
                                        {{ $tipo->Categoria }}
                                    @endif
                                @endforeach
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Elemento escondido para quando não houver produtos --}}
            <p id="semProdutos" class="text-center fw-bold mt-4" style="display:none;">
                Nenhum produto encontrado.
            </p>
        </div>
    </div>

    <script src="{{ asset('frontend/assets/js/favoritos.js') }}"></script>

    {{-- 5. RODAPÉ: Inclui o rodapé global da aplicação --}}
    @include('partial/footer')

    {{-- Scripts de Inicialização e Notificações --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // CORREÇÃO: Aplica a classe 'loaded' nas imagens de forma não intrutiva e acessível
            const imagens = document.querySelectorAll('.produto-img');
            imagens.forEach(function (img) {
                if (img.complete) {
                    img.parentElement.classList.add('loaded');
                } else {
                    img.addEventListener('load', function () {
                        this.parentElement.classList.add('loaded');
                    });
                }
            });
        });
    </script>

    @if(session('success'))
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    </script>
    @endif
</body>
</html>
