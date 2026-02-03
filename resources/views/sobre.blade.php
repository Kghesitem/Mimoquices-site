@include('partial/header')
<head>
    <link rel="stylesheet" href="frontend/assets/css/carrosel.css">
</head>

    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 d-flex flex-column align-items-center mb-4 mb-md-0">
                    <h1 class="mb-4 text-center">
                        Sobre a Mimoquices...
                    </h1>
                    <div class="container-sobre">
                        <img class="sobre" src="{{ asset('frontend/assets/img/VC.jpeg')}}" alt="">
                    </div>
                </div>
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


    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">

            <div class="carrosel">
    
            <div class="cartao max cartao-sobre animacao-home" style="border:solid 0px red;">
                <div class="container max">
                    <h2>Agendas</h2>
                    <p class="sobre">Únicas e totalmente personalizadas!São simples e funcionais, adequadas para qualquer pessoa.</p>
                    <a class="butao-sobre" href="{{ route('produto.index') }}?tipo=1">Ver opções</a>
                </div>
            </div>

            <div class="cartao max cartao-sobre animacao-home" style="border:solid 0px red;">
                <div class="container max">
                    <h2>Lembraças</h2>
                    <p class="sobre">Lembraças para casamentos e batizados pensadas para eternizar e agradercer seus convidados</p>
                    <a class="butao-sobre" href="{{ route('produto.index') }}?tipo=2">Ver opções</a>
                </div>
            </div>

            <div class="cartao max cartao-sobre animacao-home" style="border:solid 0px red;">
                <div class="container max">
                    <h2>Cadernos de Notas</h2>
                    <p class="sobre">Ideal para anotar ideias,listas,desenhar,tirar apontamentos ou usar como diário de reflexão</p>
                    <a class="butao-sobre" href="{{ route('produto.index') }}">Ver opções</a>
                </div>
            </div>
   
            </div>
        </div>
    </div>
@include('partial/footer')

