<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/carrosel.css') }}">
    <title>Sobre - Mimoquices</title>
</head>
<body>

    {{-- 1. CABEÇALHO: Inclui a barra de navegação/menu global do site --}}
    @include('partial/header')

    {{-- 2. SECÇÃO PRINCIPAL: História da Fundadora (Vânia) e da marca Mimoquices --}}
    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <div class="row align-items-center">
                
                {{-- Coluna da Esquerda: Título e Foto da Fundadora --}}
                <div class="col-md-6 d-flex flex-column align-items-center mb-4 mb-md-0">
                    <h1 class="mb-4 text-center">
                        Sobre a Mimoquices...
                    </h1>
                    <div class="container-sobre">
                        {{-- Foto pessoal da fundadora carregada através do helper asset --}}
                        <img class="sobre" src="{{ asset('frontend/assets/img/VC.jpeg') }}" alt="Vânia - Fundadora da Mimoquices">
                    </div>
                </div>
                
                {{-- Coluna da Direita: Texto Biográfico e objetivos da marca --}}
                <div class="col-md-6 d-flex align-items-start fs-4">
                    <div>
                        <p>Sou a Vânia, mãe de dois e casada com o homem mais maravilhoso que conheço.</p>
                        <p>Sou professora e adoro dar aulas, mas sou apaixonada por artesanato e por design.</p>
                        <p>A Mimoquices nasce em 2012, quando grávida do meu primeiro filho quis fazer uma peça em tecido com o nome dele para colocar no quarto.</p>
                        <p>
                            Comecei a trabalhar com feltro, mas rapidamente quis experimentar novos materiais e fazer produtos diferentes. 
                            Cada peça é feita a pensar na pessoa que a vai receber e onde coloco todo o meu amor e dedicação.
                            O compromisso com o atendimento e com a qualidade dos nossos produtos foi sempre uma prioridade.
                        </p>
                        <p>
                            O objetivo da Mimoquices é entregar felicidade!
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- 3. SECÇÃO SECUNDÁRIA: Carrosel de Destaque das Categorias de Produtos --}}
    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <div class="carrosel">
    
                {{-- Cartão 1: Agendas (Filtrado por tipo=1 no link) --}}
                <div class="cartao max cartao-sobre animacao-home" style="border: solid 0px red;">
                    <div class="container max">
                        <h2>Agendas</h2>
                        <p class="sobre">Únicas e totalmente personalizadas! São simples e funcionais, adequadas para qualquer pessoa.</p>
                        <a class="butao-sobre" href="{{ route('produto.index') }}?tipo=1">Ver opções</a>
                    </div>
                </div>

                {{-- Cartão 2: Docinhos (Filtrado por tipo=2 no link) --}}
                <div class="cartao max cartao-sobre animacao-home" style="border: solid 0px red;">
                    <div class="container max">
                        <h2>Docinhos</h2>
                        <p class="sobre">Delicadamente preparados e cheios de encanto! Docinhos únicos, feitos para adoçar cada momento com um toque especial.</p>
                        <a class="butao-sobre" href="{{ route('produto.index') }}?tipo=2">Ver opções</a>
                    </div>
                </div>

                {{-- Cartão 3: Lembranças (Corrigido o erro ortográfico de "Lembraças") --}}
                <div class="cartao max cartao-sobre animacao-home" style="border: solid 0px red;">
                    <div class="container max">
                        <h2>Lembranças</h2>
                        <p class="sobre">Lembranças para casamentos e batizados pensadas para eternizar e agradecer aos seus convidados.</p>
                        <a class="butao-sobre" href="{{ route('produto.index') }}">Ver opções</a>
                    </div>
                </div>

                {{-- Cartão 4: Cadernos de Notas --}}
                <div class="cartao max cartao-sobre animacao-home" style="border: solid 0px red;">
                    <div class="container max">
                        <h2>Cadernos de Notas</h2>
                        <p class="sobre">Ideal para anotar ideias, listas, desenhar, tirar apontamentos ou usar como diário de reflexão.</p>
                        <a class="butao-sobre" href="{{ route('produto.index') }}">Ver opções</a>
                    </div>
                </div>

                {{-- Podes adicionar outros cartões para outras categorias de produtos, se necessário --}}
   
            </div>
        </div>
    </div>

    {{-- 4. RODAPÉ: Inclui o rodapé global da aplicação --}}
    @include('partial/footer')

</body>
</html>