@include('partial/header')
<head>
    <title>{{ $produto->titulo }}- Mimoquices</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/carrosel.css') }}">
</head>
@php
    $user = Auth::user();
@endphp

<body>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    </script>
@endif

<div class="bg-white d-flex justify-content-center py-5">
    <div class="container">
        <div class="troca-colum">

            {{-- IMAGEM --}}
            <div class="d-flex flex-column align-items-center">
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

            {{-- TEXTO + FORMULÁRIO --}}
            <div>
                <h1 class="mb-3">{{ $produto->titulo }}</h1>

                <div class="mb-4">
                    <p class="fs-5">{!! nl2br(e($produto->descricao)) !!}</p>
                </div>

                {{-- ACCORDION - CONTEÚDO --}}
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

                {{-- ACCORDION - DETALHES --}}
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

                                @foreach($todas_personalizações as $personalizacao)
                                    <div class="mb-4">
                                        <label><strong>{{ $personalizacao->titulo }}</strong></label>
                                        @php
                                            $respostas = $todas_respostas->where('id_personalizacao', $personalizacao->id);
                                        @endphp

                                        @if($personalizacao->tipo_de_input === "texto")
                                            <input type="text"
                                                name="personalizacoes_opcoes[{{ $personalizacao->id }}]"
                                                class="form-control-personalizacao"
                                                value="{{ old('personalizacoes_opcoes.' . $personalizacao->id) }}"
                                                required
                                                @if(!$user || is_null($user->email_verified_at))
                                                    disabled
                                                @endif
                                                />

                                        @elseif($personalizacao->tipo_de_input === "select")
                                            <select name="personalizacoes_opcoes[{{ $personalizacao->id }}] " required
                                                    class="form-select-personalizacao">
                                                    <option value="">Selecione uma opção ...</option>
                                                @foreach($respostas as $resposta)
                                                    <option value="{{ $resposta->id }}"
                                                        @if(!$user || is_null($user->email_verified_at))
                                                            disabled
                                                        @endif
                                                        {{ old('personalizacoes_opcoes.' . $personalizacao->id) == $resposta->id ? 'selected' : '' }}>
                                                        {{ $resposta->resposta }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        @elseif($personalizacao->tipo_de_input === "checkbox")
                                            <div class="checkbox-group">
                                                @foreach($respostas as $resposta)
                                                    <label class="d-block checkbox-label">
                                                        <input type="checkbox" 
                                                            name="personalizacoes_opcoes[{{ $personalizacao->id }}][]"
                                                            value="{{ $resposta->id }}"
                                                            @if(!$user || is_null($user->email_verified_at))
                                                                disabled
                                                            @endif
                                                            {{ in_array($resposta->id, old('personalizacoes_opcoes.' . $personalizacao->id, [])) ? 'checked' : '' }}>
                                                        {{ $resposta->resposta }}
                                                    </label>
                                                @endforeach
                                            </div>
                                        @endif

                                        @if(!empty($personalizacao->PDF))
                                            <a href="{{ asset('storage/' . $personalizacao->PDF) }}" 
                                            target="_blank" 
                                            class="btn btn-outline-secondary btn-sm px-3 mt-2">
                                                Abrir PDF
                                            </a>
                                        @endif
                                    </div>
                                @endforeach

                                {{-- Botão --}}

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
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            Swal.fire({
                                                title: 'Erro!',
                                                 
                                                html: "{!! implode('<br>', array_map('e', $errors->all())) !!}",
                                                icon: 'error',
                                                confirmButtonColor: '#dc3545',
                                                confirmButtonText: 'OK'
                                            });
                                        });
                                    </script>
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

{{-- CARROSSEL DE FOTOS --}}
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
