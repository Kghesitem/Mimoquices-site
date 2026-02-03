@include('partial/header')

<head>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/carrosel.css') }}">

    <style>
        /* ================= ACCORDION ================= */
        .accordion {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .accordion summary {
            cursor: pointer;
            font-weight: 600;
            list-style: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .accordion summary::-webkit-details-marker {
            display: none;
        }

        .accordion-content {
            margin-top: 10px;
            color: #555;
        }

        /* ================= FORMULÁRIO DE PERSONALIZAÇÃO (ÚNICO) ================= */
        .formulario-personalizacao {
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(200, 146, 134, 0.3);
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group-personalizacao {
            margin-bottom: 0;
        }

        .form-group-personalizacao label {
            display: block;
            margin-bottom: 0.5rem;
            color: #0f1016;
            font-weight: 500;
        }

        .form-control-personalizacao,
        .form-select-personalizacao {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid rgba(200, 146, 134, 0.5);
            border-radius: 0.5rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control-personalizacao:focus,
        .form-select-personalizacao:focus {
            outline: none;
            border-color: #c89286;
            box-shadow: 0 0 0 3px rgba(200, 146, 134, 0.1);
        }

        .texto-contador {
            display: block;
            margin-top: 0.35rem;
            color: #999;
            font-size: 0.85rem;
        }

        /* Radio / Checkbox */
        .radio-group,
        .checkbox-group {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .radio-label,
        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
            font-weight: 400;
            margin: 0;
        }

        .radio-label input[type="radio"],
        .checkbox-label input[type="checkbox"] {
            cursor: pointer;
            accent-color: #c89286;
            width: 18px;
            height: 18px;
        }

        /* Seletor de Cores */
        .cores-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
            gap: 1rem;
        }

        .cor-opcao {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .cor-opcao input[type="radio"] {
            display: none;
        }

        .cor-botao {
            width: 60px;
            height: 60px;
            border-radius: 0.5rem;
            border: 3px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .cor-opcao input[type="radio"]:checked + .cor-botao {
            border-color: #c89286;
            box-shadow: 0 0 0 3px rgba(200, 146, 134, 0.2);
            transform: scale(1.05);
        }

        .cor-emoji {
            font-size: 1.75rem;
        }

        .cor-nome {
            font-size: 0.8rem;
            color: #666;
            text-align: center;
            font-weight: 500;
        }

        /* Botões */
        .btn-personalizar {
            width: 100%;
            padding: 0.85rem;
            margin-top: 0.5rem;
            background-color: #c89286;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-desativo {
            width: 100%;
            padding: 0.85rem;
            margin-top: 0.5rem;
            background-color: #4d4c4c63;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: auto;
        }

        .btn-personalizar:hover {
            background-color: #b87772;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(200, 146, 134, 0.3);
        }

        .btn-personalizar:active {
            transform: translateY(0);
        }

        /* Alertas */
        .alert-erros-personalizacao {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }

        .alert-erros-personalizacao strong {
            display: block;
            margin-bottom: 0.5rem;
        }

        .alert-erros-personalizacao ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .alert-erros-personalizacao li {
            margin-bottom: 0.25rem;
        }

        .alert-sucesso-personalizacao {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            font-weight: 500;
        }

        .sem-personalizacao {
            background-color: #e2e3e5;
            padding: 1rem;
            border-radius: 0.5rem;
            text-align: center;
            color: #383d41;
            font-weight: 500;
        }

        /* ================= IMAGEM PRINCIPAL ================= */
        .imagem-principal-container {
            width: 500px;
            height: 500px;
            border-radius: 1.5rem;
            margin: 0 auto;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .imagem-principal-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* ================= LAYOUT PRINCIPAL ================= */
        .troca-colum {
            display: flex;
            flex-direction: row;
            gap: 2rem;
            justify-content: center;
            align-items: flex-start;
        }

        .troca-colum > div {
            flex: 0 0 500px;
        }

        /* ================= RESPONSIVO ================= */
        @media (max-width: 1050px) {
            .troca-colum {
                flex-direction: column;
                align-items: center;
            }

            .troca-colum > div {
                flex: 0 0 auto;
                width: 100%;
            }

            .imagem-principal-container {
                width: clamp(280px, 90vw, 500px);
                height: clamp(280px, 90vw, 500px);
            }

            .cores-grid {
                grid-template-columns: repeat(auto-fit, minmax(70px, 1fr));
                gap: 0.75rem;
            }

            .cor-botao {
                width: 50px;
                height: 50px;
            }

            .formulario-personalizacao {
                padding: 1rem;
            }
        }

        /* layout “lado a lado” do formulário em ecrãs grandes */
        @media (min-width: 1050px) {
            .formulario-personalizacao {
                flex-wrap: wrap;
                flex-direction: row;
                align-items: flex-start;
            }

            .formulario-personalizacao .form-group-personalizacao {
                flex: 1 1 220px;
                min-width: 220px;
                max-width: 300px;
            }

            .formulario-personalizacao .btn-personalizar,
            .formulario-personalizacao .btn-desativo,
            .formulario-personalizacao .alert-erros-personalizacao {
                flex: 0 0 100%;
            }
        }
    </style>
</head>

<body>

@if (session('success'))
    <div class="alert-sucesso-personalizacao" style="margin: 1.5rem auto; max-width: 500px; text-align: center;">
        ✅ {{ session('success') }}
    </div>
@endif

<div class="bg-white d-flex justify-content-center py-5">
    <div class="container">
        <div class="troca-colum">

            <!-- IMAGEM -->
            <div>
                <div class="imagem-principal-container">
                    <img id="imagem-principal"
                         src="{{ asset("storage/{$produto->nome_cod}") }}"
                         alt="{{ $produto->nome_original }}">
                </div>

                <a class="btn btn-outline-primary mt-4 text-decoration-none d-flex justify-content-center"
                   href="{{ route('produto.index') }}">
                    &larr; Voltar
                </a>
            </div>

            <!-- TEXTO + FORMULÁRIO -->
            <div>
                <h1 class="mb-3">{{ $produto->titulo }}</h1>

                <div class="mb-4">
                    <p class="fs-5">{!! nl2br(e($produto->descricao)) !!}</p>
                </div>

                <!-- ACCORDION - CONTEÚDO -->
                @if($produto->conteudo)
                    <details class="accordion">
                        <summary>
                            <span>Conteúdo</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="40"
                                 height="40"
                                 viewBox="0 -960 960 960"
                                 fill="#000">
                                <path d="M480-344 240-584l47.33-47.33L480-438.67l192.67-192.66L720-584 480-344Z"/>
                            </svg>
                        </summary>

                        <div class="accordion-content">
                            <p>{!! nl2br(e($produto->conteudo)) !!}</p>
                        </div>
                    </details>
                @endif

                <!-- ACCORDION - DETALHES -->
                @if($produto->detalhes)
                    <details class="accordion">
                        <summary>
                            <span>Detalhes</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="40"
                                 height="40"
                                 viewBox="0 -960 960 960"
                                 fill="#000">
                                <path d="M480-344 240-584l47.33-47.33L480-438.67l192.67-192.66L720-584 480-344Z"/>
                            </svg>
                        </summary>

                        <div class="accordion-content">
                            <p>{!! nl2br(e($produto->detalhes)) !!}</p>
                        </div>
                    </details>
                @endif

                @php
                    $podePersonalizar = $produto->pode_personalizar === 'Sim';
                    $opcoesDisponiveis = $podePersonalizar ? json_decode($produto->personalizar_opcoes, true) : [];
                @endphp

                @if($podePersonalizar && !empty($opcoesDisponiveis))
                    <details class="accordion">
                        <summary>
                            <span>Personalização</span>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="40"
                                 height="40"
                                 viewBox="0 -960 960 960"
                                 fill="#000">
                                <path d="M480-344 240-584l47.33-47.33L480-438.67l192.67-192.66L720-584 480-344Z"/>
                            </svg>
                        </summary>

                        <div class="accordion-content">
                            <form method="POST"
                                  action="{{ route('produto.personalizar', $produto->url_completo) }}"
                                  class="formulario-personalizacao"
                                  id="meuFormulario">
                                @csrf

                                @includeWhen(
                                    optional($tipo) && trim(strtolower(optional($tipo)->Categoria)) === 'papelaria',
                                    'produto.partial.personalizacao-papelaria', 
                                    ['opcoesDisponiveis' => $opcoesDisponiveis])
                                
                                @includeWhen(
                                    optional($tipo) && trim(strtolower(optional($tipo)->Categoria)) === 'docinhos',
                                    'produto.partial.personalizacao-docinhos',
                                    ['opcoesDisponiveis' => $opcoesDisponiveis]
                                )

                                {{-- Botão --}}
                                @php
                                    $user = Auth::user();
                                @endphp

                                @if($user && !is_null($user->email_verified_at))
                                    <button type="submit" class="btn-personalizar">
                                        ✨ Personalizar Produto
                                    </button>
                                @elseif($user && is_null($user->email_verified_at))
                                    <button type="button" class="btn-desativo" disabled>
                                        Tens de confirmar o e-mail para poder personalizar
                                    </button>
                                @else
                                    <button type="button" class="btn-desativo" disabled>
                                        Tens de estar logado para personalização
                                    </button>
                                @endif


                                @if ($errors->any())
                                    <div class="alert-erros-personalizacao">
                                        <strong>Erros encontrados:</strong>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </form>
                        </div>
                    </details>
                @else
                    <p class="sem-personalizacao">
                        ℹ️ Este produto não dispõe de opções de personalização no momento.
                        Se quiser uma personalização tente falar com os nossos canais de atendimento.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- CARROSSEL DE FOTOS -->
@if($fotos && $fotos->count() > 0)
    <div class="bg-white d-flex flex-column justify-content-center align-items-center py-5">
        <div class="container">
            <div class="carrosel">
                <div>
                    <img class="fotos-img"
                         src="{{ asset('storage/' . $produto->nome_cod) }}"
                         alt="{{ $produto->nome_original }}">
                </div>
                @foreach ($fotos as $foto)
                    <div>
                        <img class="fotos-img"
                             src="{{ asset('storage/' . $foto->img_cod) }}"
                             alt="{{ $foto->img_original }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

@include('partial/footer')

<script>
    // troca de imagem principal no clique do carrossel
    const miniaturas = document.querySelectorAll('.fotos-img');
    const principal = document.getElementById('imagem-principal');

    miniaturas.forEach(img => {
        img.addEventListener('click', () => {
            principal.src = img.src;
            principal.alt = img.alt || '';

            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });

    // contador de caracteres "Texto da Capa"
    const textoCapaInput = document.getElementById('texto_capa');
    const nomeEmbalagemInput = document.getElementById('nome_embalagem');
    if (textoCapaInput) {
        const atualizarContador = () => {
            const contador = document.getElementById('contador-capa');
            if (contador) {
                contador.textContent = textoCapaInput.value.length;
            }
        };
        textoCapaInput.addEventListener('input', atualizarContador);
        atualizarContador();
    }
    if(nomeEmbalagemInput) {
        const atualizarContadorEmbalagem = () => {
            const contadorEmbalagem = document.getElementById('contador-embalagem');
            if (contadorEmbalagem) {
                contadorEmbalagem.textContent = nomeEmbalagemInput.value.length;
            }
        };
        nomeEmbalagemInput.addEventListener('input', atualizarContadorEmbalagem);
        atualizarContadorEmbalagem();
    }

    // impedir Enter de submeter o formulário
    const form = document.getElementById('meuFormulario');
    if (form) {
        form.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    }
</script>

</body>
</html>
