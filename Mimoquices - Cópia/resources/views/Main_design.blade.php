@include('partial/header')

<head>
    <link rel="stylesheet" href="frontend/assets/css/carrosel.css">
</head>
    <div class="banner">
        <img class="banner" src="frontend/assets/img/BannerPapelaria.png" alt="">
    </div>



    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <h1 class="mb-4">Ultimos Produtos adicionados:</h1>
            <div class="carrosel">
                @foreach($produtos as $produto) 
                    <a href="/produtos/{{$produto->url_completo}}" class="produtos-produto animacao-home">
                        <div>
                            <img class="produto-img" src="{{asset("Storage/{$produto->nome_cod}")}}" alt="{{$produto->nome_original}}" onload="this.parentElement.classList.add('loaded')">
                        </div>
                            <div>
                                <h3>{{$produto->titulo}}</h3> <br>
                            </div>
                            <div>
                                @foreach ($tipos as $tipo)
                                    @if ($produto->tipo_prod === $tipo->id)
                                        {{$tipo->Categoria}}
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