@include('partial/header')

    

<head>
    <link rel="stylesheet" href="frontend/assets/css/carrosel.css">
    <title>Mimoquices</title>
</head>
    <div class="banner">
        <img class="banner" src="{{ asset('frontend/assets/img/BannerPapelaria.png') }}" alt="">
    </div>



    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <h1 class="mb-4">Últimos Produtos Adicionados:</h1>
            @if($produtos->isEmpty())
                <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
                    Nenhum produto recentemente adicionado.
                </div>
            
            @else
            <div class="carrosel">
                @foreach ($produtos as $produto)
                    <a
                        href="/produtos/{{ $produto->url_completo }}"
                        class="produtos-produto animacao-home text-decoration-none"
                    >
                        <div>
                            <img
                                src="{{ asset("storage/{$produto->nome_cod}") }}"
                                alt="{{ $produto->nome_original }}"
                                class="produto-img"
                                onload="this.parentElement.classList.add('loaded')"
                            >
                        </div>

                        <div>
                            <h3>{{ $produto->titulo }}</h3>
                        </div>

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
            @endif
        </div>
        <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
    <div class="container">
        <h1 class="mb-4">Produtos em Destaque:</h1>
        @if($destaques->isEmpty())
                <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
                    Nenhum produto em destaque encontrado.
                </div>
            
            @else

        {{-- LISTA DE PRODUTOS --}}
        <div class="limite">
            @foreach($destaques as $destaque)
                <a href="/produtos/{{$destaque->url_completo}}" 
                   class="produtos-produto animacao-aparecer text-decoration-none" 
                   data-tipo="{{ $destaque->tipo_prod }}">
                    <div>
                        <img class="produto-img" 
                             src="{{asset("Storage/{$destaque->nome_cod}")}}" 
                             alt="{{$destaque->nome_original}}">
                    </div>

                    <div>
                        <h3>{{$destaque->titulo}}</h3> 
                    </div>

                    <div>
                        @foreach ($tipos as $tipo)
                            @if ($destaque->tipo_prod == $tipo->id)
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
    </div>

    


   @include('partial/footer')
</body>
</html>