@include('partial/header')

<head>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/carrosel.css') }}">

    <style>
        .accordion {
  border-bottom: 1px solid #ccc;
  padding: 10px 0;
}

.accordion summary {
  cursor: pointer;
  font-weight: 600;
  list-style: none;
    display:flex;
  justify-content: center;
  align-items: center;
}

.accordion summary::-webkit-details-marker {
  display: none;
}

.accordion-content {
  margin-top: 10px;
  color: #555;
}
    </style>

</head>

<!--

            <img class="sobre" id="imagem-principal" src="{{ asset("Storage/{$produto->nome_cod}") }}" alt="{{ $produto->nome_original }}">
        </div>
            <a class="login-logout"style="margin:30px;  text-decoration:none;" href="{{ route('produto.index') }}">&larr; Voltar</a>

<h1>{{ $produto->titulo }}</h1>
<div class="produto-descricao">
        <p>{{ $produto->descricao }}</p>
    </div>
<details class="accordion">
        <summary>
            <div class="texto" style="margin-left: 15px;">Conteúdo </div>
            <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#000000" style="margin-right: 15px;
            "><path d="M480-344 240-584l47.33-47.33L480-438.67l192.67-192.66L720-584 480-344Z"></path></svg>
        </summary>
        <div class="accordion-content">
            <p>Aqui fica o texto que aparece quando clicas.</p>
        </div>
</details>







-->
<div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <div class="row">
               <div class="col-md-6">
                    <div class="rounded-3 overflow-hidden d-flex align-items-center justify-content-center" style="border: 2px solid #c89286; aspect-ratio: 1/1; height: 550px;">
                        <img class="w-100 h-100 object-fit-cover" id="imagem-principal" src="{{ asset("Storage/{$produto->nome_cod}") }}" alt="{{ $produto->nome_original }}">
                    </div>
                    <a class="btn btn-outline-primary mt-4 text-decoration-none" href="{{ route('produto.index') }}">&larr; Voltar</a>
                </div>

                <div class="col-md-6 ps-md-4">
                    <h1 class="mb-3">{{ $produto->titulo }}</h1>
                    <div class="mb-4">
                        <p class="fs-5">{{ $produto->descricao }}</p>
                    </div>
                    <details class="accordion">
                            <summary>
                                <div class="texto" style="margin-left: 15px;">Conteúdo </div>
                                <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#000000" style="margin-right: 15px;
                                "><path d="M480-344 240-584l47.33-47.33L480-438.67l192.67-192.66L720-584 480-344Z"></path></svg>
                            </summary>
                            <div class="accordion-content">
                                <p>Aqui fica o texto que aparece quando clicas.</p>
                            </div>
                    </details>
                </div>

            </div>
        </div>
    </div>


@if(isset($fotos))
<div class="Produto">
    <h1>Mais Fotos do/a {{ $produto->titulo }}</h1>
    <div class="carrosel">
        <div>
            <img class="fotos-img" src="{{ asset("Storage/{$produto->nome_cod}") }}" alt="{{ $produto->nome_original }}">
        </div>
        
    

       @foreach ($fotos as $foto)
            @if (!empty($foto->img_cod))
                <div>
                    <img class="fotos-img" src="{{ asset('storage/' . $foto->img_cod) }}">
                </div>
            @endif
        @endforeach



    </div>
</div>
@endif

@include('partial/footer')

<script>
    // seleciona todas as miniaturas
    const miniaturas = document.querySelectorAll('.fotos-img');
    const principal = document.getElementById('imagem-principal');

    miniaturas.forEach(img => {
        img.addEventListener('click', () => {
            principal.src = img.src;
            principal.alt = img.alt;
        });
    });
</script>

</body>
</html>
