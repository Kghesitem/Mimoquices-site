
@include('partial.header')
<head>
    <title>Criar Produto - Mimoquices</title>
</head>
<a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}">
        ← Voltar
    </a>

<body>
    <main class="profile-page py-5">
    <div class="container">
    <div class="form-container">
        <h1>➕ Criar Produtos</h1>

        <!-- Erros -->
        @if($errors->any())
        <div class="alert-errors">
            <strong>Erros encontrados:</strong>
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="post" action="{{ route('produto.store') }}" enctype="multipart/form-data">
            @csrf
            @method('post')

            <!-- Título -->
            <div class="form-group">
                <label for="titulo">Título do Produto</label>
                <input 
                    type="text" 
                    id="titulo"
                    class="form-control" 
                    name="titulo" 
                    placeholder="Ex.: Caderno A5" 
                    required
                    value="{{ old('titulo') }}"
                />
            </div>

            <!-- Descrição -->
            <div class="form-group">
                <label for="descricao">Descrição do Produto</label>
                <textarea 
                    id="descricao"
                    class="form-control" 
                    name="descricao" 
                    placeholder="Descreva o produto de forma detalhada..." 
                    required
                >{{ old('descricao') }}</textarea>
            </div>

            <div class="form-group">
                <label for="conteudo">Conteúdo</label>
                <textarea 
                    id="conteudo"
                    class="form-control" 
                    name="conteudo" 
                    placeholder="Conteudo do produto..."
                >{{ old('conteudo') }}</textarea>
            </div>

            <div class="form-group">
                <label for="detalhes">Detalhes</label>
                <textarea 
                    id="detalhes"
                    class="form-control" 
                    name="detalhes" 
                    placeholder="Detalhes do produto..."
                >{{ old('detalhes') }}</textarea>
            </div>

            <!-- Categoria -->
            <div class="form-group">
                <label for="categoria">Categoria</label>
                <select 
                    id="categoria" 
                    class="form-select" 
                    name="tipo_prod" 
                    onchange="verificaCategoria()"
                    required
                >
                    <option value="">Selecione uma categoria...</option>
                    @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}" {{ old('tipo_prod') == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->Categoria }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Imagens -->
            <div class="form-group">
                <label for="images">Imagens do Produto</label>
                <input 
                    type="file" 
                    id="images" 
                    class="form-control" 
                    name="nome_original[]" 
                    accept="image/*" 
                    multiple 
                    onchange="previewImages(this)"
                    required
                />
                <small class="text-muted">Pode selecionar várias imagens. Tamanho máximo: 5MB por imagem.</small>
                <div class="preview" id="preview">
                    <div class="preview-empty">Nenhuma imagem selecionada</div>
                </div>
            </div>

            <!-- BLOCO DE PERSONALIZAÇÃO (ADMIN) - Só aparece para Papelaria -->
            <div id="bloco-personalizacao-admin" class="hidden">
            <div class="admin-info">
                <strong>⚙️ Modo Admin:</strong>
                <span>Configure as opções de personalização disponíveis para os clientes</span>
            </div>

                <!-- Radio: Pode ser personalizado? -->
                <div class="form-group">
                    <label>Este produto pode ser personalizado?</label>
                    <div class="radio-personalizacao">
                        <label>
                            <input 
                                type="radio" 
                                name="pode_personalizar" 
                                value="Sim"
                                onchange="toggleOpcoes()"
                                {{ old('pode_personalizar') == 'Sim' ? 'checked' : '' }}
                            />
                            Sim - permitir personalização
                        </label>
                        <label>
                            <input 
                                type="radio" 
                                name="pode_personalizar" 
                                value="Não"
                                onchange="toggleOpcoes()"
                                {{ old('pode_personalizar') == 'Não' || !old('pode_personalizar') ? 'checked' : '' }}
                            />
                            Não
                        </label>
                    </div>
                </div>

                <!-- Opções de Personalização (aparecem se escolher Sim) -->
                <div id="opcoes-personalizacao" {{ old('pode_personalizar') == 'Sim' ? 'class="visible"' : '' }}>
                    <h6 style="color: var(--color1); margin-bottom: 1rem;">
                        ✅ Selecione as opções de personalização que os clientes poderão usar:
                    </h6>
                    <div id="opcoes-papelaria" class="opcoes-personalizacao">
                        <div class="opcoes-grid">

                            @foreach($todas_personalizações as $personalizacao)
                                <div class="opcao-item" 
                                    data-categorias="{{ $personalizacao->tipos->pluck('id')->implode(',') }}">
                                    <input 
                                        type="checkbox" 
                                        id="personalizacao_{{ $personalizacao->id }}" 
                                        name="personalizar_opcoes[]" 
                                        value="{{ $personalizacao->id }}"
                                        {{ in_array($personalizacao->id, old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                    />
                                    <div class="opcao-descricao">
                                        <label for="personalizacao_{{ $personalizacao->id }}">
                                            {{ $personalizacao->titulo }}
                                        </label>
                                        <small>{{ $personalizacao->descricao }}</small>
                                    </div>
                                </div>
                            @endforeach


                    </div>  
                </div>
            </div>

            <!-- Botão Submit -->
            <button type="submit" class="btn-submit">💾 Guardar Produto</button>
        </form>
    </div>
</body>
    @include('partial.footer')

    <script>
        /**
         * Verifica se a categoria selecionada é Papelaria (valor 1)
         * Se for, mostra o bloco de personalização admin
         */
        function verificaCategoria() {
            const select = document.getElementById('categoria');
            const blocoAdmin = document.getElementById('bloco-personalizacao-admin');

            if (select.value !== '' ) {
                blocoAdmin.classList.remove('hidden');
            }else {
                blocoAdmin.classList.add('hidden');
                // Reset checkboxes
                document.querySelectorAll('input[name^="personalizar_opcoes"]').forEach(cb => cb.checked = false);
            }

            const categoriaSelecionada = document.getElementById('categoria').value;
            const opcoes = document.querySelectorAll('.opcao-item');

            opcoes.forEach(opcao => {
                const categorias = opcao.dataset.categorias.split(',');

                if (!categoriaSelecionada || categorias.includes(categoriaSelecionada)) {
                    opcao.style.display = 'flex';
                } else {
                    opcao.style.display = 'none';
                    const checkbox = opcao.querySelector('input[type="checkbox"]');
                    if (checkbox) checkbox.checked = false;
                }
            });
        }



        /**
         * Mostra/esconde as opções de personalização
         * baseado na seleção do radio button "Sim/Não"
         */
        function toggleOpcoes() {
            const sim = document.querySelector('input[name="pode_personalizar"][value="Sim"]');
            const opcoesDiv = document.getElementById('opcoes-personalizacao');

            if (sim.checked) {
                opcoesDiv.classList.add('visible');
            } else {
                opcoesDiv.classList.remove('visible');
                // Desmarcar todas as opções se escolher Não
                document.querySelectorAll('input[name="personalizar_opcoes[]"]').forEach(cb => {
                    cb.checked = false;
                });
            }
        }

        /**
         * Pré-visualiza as imagens selecionadas
         */
        function previewImages(input) {
            const preview = document.getElementById('preview');
            preview.innerHTML = ''; // limpa a pré-visualização

            const files = input.files;
            if (files.length === 0) {
                preview.innerHTML = '<div class="preview-empty">Nenhuma imagem selecionada</div>';
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = `Preview ${i + 1}`;
                        preview.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                } else {
                    console.warn(`Ficheiro ${file.name} não é uma imagem válida`);
                }
            }
        }

        // Inicializar o formulário ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            verificaCategoria();
        });
    </script>

