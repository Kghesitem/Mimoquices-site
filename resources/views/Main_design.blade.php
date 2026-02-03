@include('partial/header')

<head>
    <link rel="stylesheet" href="frontend/assets/css/carrosel.css">
</head>
    <div class="banner">
        <img class="banner" src="{{ asset('frontend/assets/img/BannerPapelaria.png') }}" alt="">
    </div>



    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <h1 class="mb-4">Últimos Produtos Adicionados:</h1>

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
        </div>
    </div>

    


   @include('partial/footer')
</body>
</html>