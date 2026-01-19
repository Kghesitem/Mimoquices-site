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

        /* ================= FORMULÁRIO DE PERSONALIZAÇÃO ================= */
        .formulario-personalizacao {
            background-color: #f9f9f9;
            padding: 1.5rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(200, 146, 134, 0.3);
        }

        /* Formulário para Desktop */
        .formulario-personalizacao-desktop {
            display: none;
            background-color: #f9f9f9;
            padding: 2rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(200, 146, 134, 0.3);
            margin: 2rem auto;
            max-width: 100%;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: flex-start;
        }

        .formulario-personalizacao-desktop .form-group-personalizacao {
            flex: 0 0 auto;
            min-width: 200px;
        }

        .formulario-personalizacao-desktop .btn-personalizar {
            flex: 0 0 100%;
            margin-top: 1rem;
        }

        /* Desktop: mostrar formulário horizontal */
        @media (min-width: 1051px) {
            .formulario-personalizacao-desktop {
                display: flex;
            }

            .accordion-personalizacao-mobile {
                display: none;
            }
        }

        .form-group-personalizacao {
            margin-bottom: 1.5rem;
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

        /* Radio Buttons */
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

        /* Botão Personalizar */
        .btn-personalizar {
            width: 100%;
            padding: 0.85rem;
            margin-top: 1rem;
            background-color: #c89286;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
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
            border: 2px solid #c89286;
            border-radius: 1.5rem;
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
            flex-direction: row; /* Desktop: lado a lado */
            gap: 2rem;
            justify-content: center;
            align-items: flex-start;
        }

        /* Faz imagem e texto terem a mesma largura */
        .troca-colum > div {
            flex: 0 0 500px; /* mesma largura que a imagem */
        }

        /* ================= MOBILE ================= */
        @media (max-width: 1050px) {
            .troca-colum {
                flex-direction: column; /* empilhado */
                align-items: center;
            }

            .troca-colum > div {
                flex: 0 0 auto;
                width: 100%; /* ocupam 100% no mobile */
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

                <a class="btn btn-outline-primary mt-4 text-decoration-none"
                   href="{{ route('produto.index') }}">
                    &larr; Voltar
                </a>
            </div>

            <!-- TEXTO -->
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

                <!-- ACCORDION - PERSONALIZAÇÃO (MOBILE) -->
                @php
                    $podePersonalizar = $produto->pode_personalizar === 'Sim';
                    $opcoesDisponiveis = $podePersonalizar ? json_decode($produto->personalizar_opcoes, true) : [];
                @endphp

                <details class="accordion accordion-personalizacao-mobile">
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
                        @if($podePersonalizar && !empty($opcoesDisponiveis))
                            <form method="POST" action="{{ route('produto.personalizar', $produto->url_completo) }}" class="formulario-personalizacao">
                                @csrf

                                <!-- Texto da Capa -->
                                @if(in_array('texto_capa', $opcoesDisponiveis))
                                <div class="form-group-personalizacao">
                                    <label for="texto_capa">
                                        📝 <strong>Texto da Capa</strong>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="texto_capa"
                                        name="texto_capa" 
                                        class="form-control-personalizacao"
                                        placeholder="Máximo 30 caracteres"
                                        maxlength="30"
                                        value="{{ old('texto_capa') }}"
                                    />
                                    <small class="texto-contador">
                                        <span id="contador-capa">0</span>/30 caracteres
                                    </small>
                                </div>
                                @endif

                                <!-- Formato da Agenda -->
                                @if(in_array('formato', $opcoesDisponiveis))
                                <div class="form-group-personalizacao">
                                    <label><strong>📅 Formato da Agenda</strong></label>
                                    <a href="{{ asset('frontend/assets/pdf/modelos-agendas-26.pdf') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        📥 Descarregar PDF
                                    </a>
                                    <div class="radio-group mt-3">
                                        <label class="radio-label">
                                            <input 
                                                type="radio" 
                                                name="formato_agenda" 
                                                value="Com horas"
                                                {{ old('formato_agenda') == 'Com horas' ? 'checked' : '' }}
                                            />
                                            Com horas
                                        </label>
                                        <label class="radio-label">
                                            <input 
                                                type="radio" 
                                                name="formato_agenda" 
                                                value="Sem horas"
                                                {{ old('formato_agenda') == 'Sem horas' ? 'checked' : '' }}
                                            />
                                            Sem horas
                                        </label>
                                    </div>
                                </div>
                                @endif

                                <!-- Páginas Especiais -->
                                @if(in_array('paginas', $opcoesDisponiveis))
                                <div class="form-group-personalizacao">
                                    <label><strong>📄 Páginas no Final de Cada Mês</strong></label>
                                    <div class="checkbox-group">
                                        <label class="checkbox-label">
                                            <input 
                                                type="checkbox" 
                                                name="paginas_especiais[]" 
                                                value="Anotacoes"
                                                {{ in_array('Anotacoes', old('paginas_especiais', [])) ? 'checked' : '' }}
                                            />
                                            📌 Anotações
                                        </label>
                                        <label class="checkbox-label">
                                            <input 
                                                type="checkbox" 
                                                name="paginas_especiais[]" 
                                                value="Objetivos"
                                                {{ in_array('Objetivos', old('paginas_especiais', [])) ? 'checked' : '' }}
                                            />
                                            🎯 Objetivos
                                        </label>
                                        <label class="checkbox-label">
                                            <input 
                                                type="checkbox" 
                                                name="paginas_especiais[]" 
                                                value="Habitos"
                                                {{ in_array('Habitos', old('paginas_especiais', [])) ? 'checked' : '' }}
                                            />
                                            ⭐ Hábitos
                                        </label>
                                        <label class="checkbox-label">
                                            <input 
                                                type="checkbox" 
                                                name="paginas_especiais[]" 
                                                value="Financeiro"
                                                {{ in_array('Financeiro', old('paginas_especiais', [])) ? 'checked' : '' }}
                                            />
                                            💰 Financeiro
                                        </label>
                                    </div>
                                </div>
                                @endif

                                <!-- Acessório -->
                                @if(in_array('acessorio', $opcoesDisponiveis))
                                <div class="form-group-personalizacao">
                                    <label for="acessorio"><strong>⭕ Acessório do Elástico</strong></label>
                                    <select 
                                        id="acessorio" 
                                        name="acessorio" 
                                        class="form-select-personalizacao"
                                    >
                                        <option value="">Selecione uma opção...</option>
                                        <option value="Metálico" {{ old('acessorio') == 'Metálico' ? 'selected' : '' }}>
                                            ✨ Metálico
                                        </option>
                                        <option value="Acrílico" {{ old('acessorio') == 'Acrílico' ? 'selected' : '' }}>
                                            💎 Acrílico
                                        </option>
                                    </select>
                                </div>
                                @endif

                                <!-- Cor das Argolas -->
                                @if(in_array('cor_argolas', $opcoesDisponiveis))
                                <div class="form-group-personalizacao">
                                    <label><strong>🎨 Cor das Argolas</strong></label>
                                    <div class="cores-grid">
                                        @php
                                            $cores = [
                                                ['valor' => 'Prata', 'emoji' => '🤍', 'cor' => '#c0c0c0'],
                                                ['valor' => 'Ouro', 'emoji' => '💛', 'cor' => '#ffd700'],
                                                ['valor' => 'Preto', 'emoji' => '🖤', 'cor' => '#000000'],
                                                ['valor' => 'Rose Gold', 'emoji' => '🌹', 'cor' => '#b76e79'],
                                                ['valor' => 'Cobre', 'emoji' => '🧡', 'cor' => '#b87333'],
                                            ]
                                        @endphp
                                        @foreach($cores as $cor)
                                        <label class="cor-opcao">
                                            <input 
                                                type="radio" 
                                                name="cor_argolas" 
                                                value="{{ $cor['valor'] }}"
                                                {{ old('cor_argolas') == $cor['valor'] ? 'checked' : '' }}
                                            />
                                            <div class="cor-botao" style="background-color: {{ $cor['cor'] }}" title="{{ $cor['valor'] }}">
                                                <span class="cor-emoji">{{ $cor['emoji'] }}</span>
                                            </div>
                                            <span class="cor-nome">{{ $cor['valor'] }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Botão Submit -->
                                <button type="submit" class="btn-personalizar">
                                    ✨ Personalizar Produto
                                </button>

                            </form>

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
                        @else
                            <p class="sem-personalizacao">
                                ℹ️ Este produto não dispõe de opções de personalização no momento.
                                Se quiser uma personalização tente falar com os nossos canais de atendimento.
                            </p>
                        @endif
                    </div>
                </details>
            </div>
        </div>
    </div>
</div>

<!-- FORMULÁRIO DE PERSONALIZAÇÃO PARA DESKTOP (>1050px) -->
@if($podePersonalizar && !empty($opcoesDisponiveis))
<div class="bg-white d-flex justify-content-center py-5">
    <div class="container">
        <form method="POST" action="{{ route('produto.personalizar', $produto->url_completo) }}" class="formulario-personalizacao-desktop">
            @csrf

            <!-- Texto da Capa -->
            @if(in_array('texto_capa', $opcoesDisponiveis))
            <div class="form-group-personalizacao">
                <label for="texto_capa_desktop">
                    📝 <strong>Texto da Capa</strong>
                </label>
                <input 
                    type="text" 
                    id="texto_capa_desktop"
                    name="texto_capa" 
                    class="form-control-personalizacao"
                    placeholder="Máximo 30 caracteres"
                    maxlength="30"
                    value="{{ old('texto_capa') }}"
                />
                <small class="texto-contador">
                    <span id="contador-capa-desktop">0</span>/30 caracteres
                </small>
            </div>
            @endif

            <!-- Formato da Agenda -->
            @if(in_array('formato', $opcoesDisponiveis))
            <div class="form-group-personalizacao">
                <label><strong>📅 Formato</strong><br>
                <a href="{{ asset('frontend/assets/pdf/modelos-agendas-26.pdf') }}" target="_blank">
                    📥 Modelos disponíveis
                </a></label>
                
                <div class="radio-group mt-3">
                    <label class="radio-label">
                        <input 
                            type="radio" 
                            name="formato_agenda" 
                            value="Com horas"
                            {{ old('formato_agenda') == 'Com horas' ? 'checked' : '' }}
                        />
                        Com horas
                    </label>
                    <label class="radio-label">
                        <input 
                            type="radio" 
                            name="formato_agenda" 
                            value="Sem horas"
                            {{ old('formato_agenda') == 'Sem horas' ? 'checked' : '' }}
                        />
                        Sem horas
                    </label>
                </div>
            </div>
            @endif

            <!-- Acessório -->
            @if(in_array('acessorio', $opcoesDisponiveis))
            <div class="form-group-personalizacao">
                <label for="acessorio_desktop"><strong>⭕ Acessório</strong></label>
                <select 
                    id="acessorio_desktop" 
                    name="acessorio" 
                    class="form-select-personalizacao"
                >
                    <option value="">Selecione...</option>
                    <option value="Metálico" {{ old('acessorio') == 'Metálico' ? 'selected' : '' }}>
                        ✨ Metálico
                    </option>
                    <option value="Acrílico" {{ old('acessorio') == 'Acrílico' ? 'selected' : '' }}>
                        💎 Acrílico
                    </option>
                </select>
            </div>
            @endif

            <!-- Páginas Especiais -->
            @if(in_array('paginas', $opcoesDisponiveis))
            <div class="form-group-personalizacao">
                <label><strong>📄 Páginas</strong></label>
                <div class="checkbox-group">
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="paginas_especiais[]" 
                            value="Anotacoes"
                            {{ in_array('Anotacoes', old('paginas_especiais', [])) ? 'checked' : '' }}
                        />
                        📌 Anotações
                    </label>
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="paginas_especiais[]" 
                            value="Objetivos"
                            {{ in_array('Objetivos', old('paginas_especiais', [])) ? 'checked' : '' }}
                        />
                        🎯 Objetivos
                    </label>
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="paginas_especiais[]" 
                            value="Habitos"
                            {{ in_array('Habitos', old('paginas_especiais', [])) ? 'checked' : '' }}
                        />
                        ⭐ Hábitos
                    </label>
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="paginas_especiais[]" 
                            value="Financeiro"
                            {{ in_array('Financeiro', old('paginas_especiais', [])) ? 'checked' : '' }}
                        />
                        💰 Financeiro
                    </label>
                </div>
            </div>
            @endif

            <!-- Cor das Argolas - ADICIONADO AO DESKTOP -->
            @if(in_array('cor_argolas', $opcoesDisponiveis))
            <div class="form-group-personalizacao">
                <label><strong>🎨 Cor das Argolas</strong></label>
                <div class="cores-grid">
                    @php
                        $cores = [
                            ['valor' => 'Prata', 'emoji' => '🤍', 'cor' => '#c0c0c0'],
                            ['valor' => 'Ouro', 'emoji' => '💛', 'cor' => '#ffd700'],
                            ['valor' => 'Preto', 'emoji' => '🖤', 'cor' => '#000000'],
                            ['valor' => 'Rose Gold', 'emoji' => '🌹', 'cor' => '#b76e79'],
                            ['valor' => 'Cobre', 'emoji' => '🧡', 'cor' => '#b87333'],
                        ]
                    @endphp
                    @foreach($cores as $cor)
                    <label class="cor-opcao">
                        <input 
                            type="radio" 
                            name="cor_argolas" 
                            value="{{ $cor['valor'] }}"
                            {{ old('cor_argolas') == $cor['valor'] ? 'checked' : '' }}
                        />
                        <div class="cor-botao" style="background-color: {{ $cor['cor'] }}" title="{{ $cor['valor'] }}">
                            <span class="cor-emoji">{{ $cor['emoji'] }}</span>
                        </div>
                        <span class="cor-nome">{{ $cor['valor'] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            @endif

            <button type="submit" class="btn-personalizar">
                ✨ Personalizar Produto
            </button>
        </form>

        @if ($errors->any())
        <div class="alert-erros-personalizacao" style="margin: 1.5rem auto; max-width: 1000px;">
            <strong>Erros encontrados:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
@endif

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
    const miniaturas = document.querySelectorAll('.fotos-img');
    const principal = document.getElementById('imagem-principal');

    miniaturas.forEach(img => {
        img.addEventListener('click', () => {
            principal.src = img.src;
            principal.alt = img.alt || '';
        });
    });

    // Contador de caracteres para "Texto da Capa" - MOBILE
    const textoCapaInput = document.getElementById('texto_capa');
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

    // Contador de caracteres para "Texto da Capa" - DESKTOP
    const textoCapaInputDesktop = document.getElementById('texto_capa_desktop');
    if (textoCapaInputDesktop) {
        const atualizarContadorDesktop = () => {
            const contador = document.getElementById('contador-capa-desktop');
            if (contador) {
                contador.textContent = textoCapaInputDesktop.value.length;
            }
        };

        textoCapaInputDesktop.addEventListener('input', atualizarContadorDesktop);
        atualizarContadorDesktop();
    }
</script>

</body>
</html>
