<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Personalização - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
    <style>
        .hidden {
            display: none !important;
        }
    </style>
</head>
<body>

@include('partial.header')

<main style="padding: 1rem 1rem;">
<div class="auth-container auth-container-full">
    
    {{-- Botão Voltar --}}
    <div class="d-flex justify-content-center" style="margin-bottom: 1.5rem;">
        <a class="btn botao-voltar text-decoration-none d-inline-flex align-items-center" href="{{ url('/categoria/criar') }}" style="gap: 0.5rem;">
            ← Voltar para o Criar Categoria
        </a>
    </div>  

    {{-- CABEÇALHO DO FORMULÁRIO --}}
    <div class="auth-header rounded" style="text-align: left; margin-bottom: 2.5rem;">
        <h1>
            <x-heroicon-m-folder-open style="width: 2.5rem; height: 2.5rem; vertical-align: middle; color:var(--main_color);" /> 
            Editar Personalização
        </h1>
        <p style="text-align: center;">Modifique as configurações e opções dos campos personalizados deste registo</p>
    </div>

    {{-- ERROS VIA SWEETALERT --}}
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

    {{-- FORMULÁRIO DE EDIÇÃO --}}
    <form method="post" enctype="multipart/form-data" action="{{ route('personalizacao.update', $personalizacao->id) }}" class="auth-form" style="max-width: 100%;">
        @csrf
        @method('PUT')

        <div class="form-grid-layout">
            
            {{-- COLUNA ESQUERDA: Dados Gerais da Personalização --}}
            <div class="col-dados">
                {{-- Nome da Personalização --}}
                <div class="form-group">
                    <label for="nome" class="form-label">Nome da Personalização</label>
                    <input 
                        type="text" 
                        id="nome"
                        class="form-input {{ $errors->has('nome') ? 'is-invalid' : '' }}" 
                        name="nome" 
                        placeholder="Ex.: Papelaria, Agendas..." 
                        required
                        value="{{ old('nome', $personalizacao->titulo) }}"
                    />
                </div>

                {{-- Breve Descrição --}}
                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="descricao" class="form-label">Breve Descrição</label>
                    <input 
                        type="text" 
                        id="descricao"
                        class="form-input {{ $errors->has('descricao') ? 'is-invalid' : '' }}" 
                        name="descricao" 
                        placeholder="Ex.: Pode ser personalizada com nome, data ou frase..." 
                        required
                        value="{{ old('descricao', $personalizacao->descricao) }}"
                    />
                </div>

                {{-- Ficheiro Auxiliar (PDF) --}}
                <div class="form-group" style="margin-top: 1.25rem;">
                    <label for="pdf" class="form-label">PDF Auxiliar</label>
                    <input 
                        type="file" 
                        id="pdf"
                        class="form-input {{ $errors->has('pdf') ? 'is-invalid' : '' }}" 
                        name="pdf" 
                        accept=".pdf"
                    />
                    @if($personalizacao->PDF)
                        <small class="text-success" style="display: block; margin-top: 0.25rem;">
                            📄 Já existe um PDF guardado. Carregue um novo apenas se pretender substituir.
                        </small>
                    @else
                        <small class="text-muted" style="display: block; margin-top: 0.25rem;">Documento opcional de suporte para a personalização.</small>
                    @endif
                </div>
            </div>

            {{-- COLUNA DIREITA: Regras de Input e Opções Dinâmicas --}}
            <div class="col-media">
                {{-- Tipo de Entrada de Dados --}}
                <div class="form-group">
                    <label for="categoria" class="form-label">O Utilizador introduz dados</label>
                    <select id="categoria" class="form-input form-select" name="tipo_de_input" onchange="verificaCategoria()" required>
                        <option value="texto" {{ old('tipo_de_input', $personalizacao->tipo_de_input) == 'texto' ? 'selected' : '' }}>Em forma de texto</option>
                        <option value="select" {{ old('tipo_de_input', $personalizacao->tipo_de_input) == 'select' ? 'selected' : '' }}>Seleciona apenas uma opção entre várias possíveis</option>
                        <option value="checkbox" {{ old('tipo_de_input', $personalizacao->tipo_de_input) == 'checkbox' ? 'selected' : '' }}>Seleciona uma ou mais opções entre várias possíveis</option>
                    </select>
                </div>

                {{-- Bloco Informativo: Texto --}}
                <div id="texto" name="texto" class="border rounded p-3 bg-light mb-3" style="margin-top: 1.25rem;">
                    <h5 class="mb-0" style="font-size: 1rem; color: #555;">O Utilizador pode introduzir dados em forma de texto livre.</h5>
                </div>

                {{-- Bloco Dinâmico: Select / Checkbox --}}
                <div id="select" class="hidden border rounded p-3 bg-light mb-3" style="margin-top: 1.25rem;">
                    <div class="d-flex justify-content-between align-items-center mb-3" style="flex-wrap: wrap; gap: 0.5rem;">
                        <h6 class="mb-0 fw-semibold" style="font-size: 1rem;">Opções de Escolha</h6>

                        <div class="d-flex gap-2">
                            <button type="button" id="add-input" class="btn btn-success btn-sm d-inline-flex align-items-center" style="gap: 0.25rem; font-weight: 600;">
                                <span>+</span> Adicionar
                            </button>

                            <button type="button" id="remove-input" class="btn btn-danger btn-sm d-inline-flex align-items-center" style="gap: 0.25rem; font-weight: 600;">
                                <span>-</span> Remover
                            </button>
                        </div>                        
                    </div>

                    <div id="inputs-container">
                        {{-- Renderiza as opções existentes vindas da base de dados --}}
                        @if(isset($respostas) && $respostas->isNotEmpty())
                            @foreach($respostas as $index => $campo)
                                <div class="input-group mb-2" style="display: flex; gap: 0.25rem;">
                                    <span class="input-group-text fw-semibold" style="background: #e9ecef; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem 0 0 0.25rem; font-size: 0.9rem;">Opção {{ $index + 1 }}</span>
                                    <input
                                        type="text"
                                        name="campos[]"
                                        class="form-control form-input"
                                        value="{{ old('campos.'.$index, $campo->resposta) }}"
                                        placeholder="Texto da opção"
                                        style="margin: 0; border-radius: 0 0.25rem 0.25rem 0; flex: 1;"
                                    >
                                </div>
                            @endforeach
                        @else
                            {{-- Input padrão de fallback caso não haja nenhuma opção gravada ainda --}}
                            <div class="input-group mb-2" style="display: flex; gap: 0.25rem;">
                                <span class="input-group-text fw-semibold" style="background: #e9ecef; padding: 0.375rem 0.75rem; border: 1px solid #ced4da; border-radius: 0.25rem 0 0 0.25rem; font-size: 0.9rem;">Opção 1</span>
                                <input
                                    type="text"
                                    name="campos[]"
                                    class="form-control form-input"
                                    placeholder="Texto da opção"
                                    style="margin: 0; border-radius: 0 0.25rem 0.25rem 0; flex: 1;"
                                >
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- BOTÃO SUBMIT (Ocupa a largura total da grid) --}}
            <div class="grid-full-width">
                <button type="submit" class="btn-submit" style="margin-top: 1.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onclick="this.disabled=true; this.form.submit();">
                    <x-heroicon-c-bookmark style="width: 1.25rem; height: 1.25rem;"/> Guardar Alterações
                </button>
            </div>

        </div>
    </form>

    {{-- RODAPÉ INDENTADO --}}
    <div class="auth-footer" style="margin-top: 3rem;">
        <p>Pretende gerir outras definições?</p>
        <a href="{{ url('/dashboard') }}">Voltar para o Dashboard →</a>
    </div>
</div>
</main>

@include('partial.footer')

<script>
    function verificaCategoria() {
        const select = document.getElementById('categoria');
        const blocoTexto = document.getElementById('texto');
        const blocoSelect = document.getElementById('select');

        if (select.value === "texto") {
            blocoTexto.classList.remove('hidden');
            blocoSelect.classList.add('hidden');
        } else if (select.value === "select" || select.value === "checkbox") {
            blocoTexto.classList.add('hidden');
            blocoSelect.classList.remove('hidden');
        }
    }

    // Inicializa o estado correto e define o contador inicial baseado nos elementos renderizados
    let contador = 1;
    
    document.addEventListener("DOMContentLoaded", function() {
        verificaCategoria();
        // Atualiza o contador de acordo com o número de registos que vieram do banco de dados
        contador = document.querySelectorAll('#inputs-container .input-group').length || 1;
    });

    document.getElementById('add-input').addEventListener('click', function () {
        contador++;

        const container = document.getElementById('inputs-container');

        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.style.display = 'flex';
        div.style.gap = '0.25rem';

        const label = document.createElement('span');
        label.className = 'input-group-text fw-semibold';
        label.style.background = '#e9ecef';
        label.style.padding = '0.375rem 0.75rem';
        label.style.border = '1px solid #ced4da';
        label.style.borderRadius = '0.25rem 0 0 0.25rem';
        label.style.fontSize = '0.9rem';
        label.innerText = 'Opção ' + contador;

        const input = document.createElement('input');
        input.type = 'text';
        input.name = 'campos[]';
        input.className = 'form-control form-input';
        input.style.margin = '0';
        input.style.borderRadius = '0 0.25rem 0.25rem 0';
        input.style.flex = '1';
        input.placeholder = 'Texto da opção';

        div.appendChild(label);
        div.appendChild(input);
        container.appendChild(div);
    });

    document.getElementById('remove-input').addEventListener('click', function () {
        if (contador > 1) {
            contador--;
            const container = document.getElementById('inputs-container');
            const divs = container.querySelectorAll('.input-group');
            if (divs.length > 0) {
                container.removeChild(divs[divs.length - 1]);
            }
        }
    });
</script>
</body>
</html>