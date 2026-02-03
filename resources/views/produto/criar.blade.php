<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --main_color: #c89286;
            --color1: #0f1016;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', Arial, sans-serif;
        }

        .form-container {
            max-width: 700px;
            margin: 3rem auto;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            border: 2px solid var(--main_color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-container h1 {
            color: var(--color1);
            margin-bottom: 2rem;
            font-weight: 600;
            text-align: center;
            font-family: Georgia, "Times New Roman", serif;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-weight: 600;
            color: var(--color1);
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control, .form-select {
            border: 1px solid rgba(200, 146, 134, 0.5);
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--main_color);
            box-shadow: 0 0 0 0.2rem rgba(200, 146, 134, 0.25);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 120px;
            font-family: 'Poppins', Arial, sans-serif;
        }

        /* Pré-visualização das imagens */
        .preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 1rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px dashed var(--main_color);
            min-height: 100px;
            align-items: flex-start;
        }

        .preview img {
            max-width: 150px;
            height: 150px;
            object-fit: cover;
            border: 2px solid var(--main_color);
            border-radius: 0.5rem;
            transition: transform 0.2s ease;
        }

        .preview img:hover {
            transform: scale(1.05);
        }

        .preview-empty {
            color: #999;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }

        /* Bloco de personalização (Admin) */
        #bloco-personalizacao-admin {
            background-color: #f0f0f0;
            padding: 1.5rem;
            border-radius: 0.5rem;
            border-left: 4px solid var(--main_color);
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        #bloco-personalizacao-admin.hidden {
            display: none;
        }

        .admin-info {
            background-color: #e3f2fd;
            border: 1px solid #90caf9;
            color: #1565c0;
            padding: 0.75rem;
            border-radius: 0.4rem;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: flex;
            gap: 0.5rem;
        }

        .admin-info strong {
            color: #0d47a1;
        }

        /* Radio buttons para Sim/Não personalização */
        .radio-personalizacao {
            display: flex;
            gap: 2rem;
            margin: 1rem 0;
        }

        .radio-personalizacao label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0;
            font-weight: 400;
            cursor: pointer;
        }

        .radio-personalizacao input[type="radio"] {
            cursor: pointer;
            accent-color: var(--main_color);
        }

        /* Opções de personalização (checkboxes) */
        #opcoes-personalizacao {
            display: none;
            background-color: white;
            padding: 1.5rem;
            margin-top: 1rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(200, 146, 134, 0.3);
            animation: slideDown 0.3s ease;
        }

        #opcoes-personalizacao.visible {
            display: block;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .opcoes-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .opcao-item {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 1rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            border: 1px solid rgba(200, 146, 134, 0.2);
            transition: all 0.2s ease;
        }

        .opcao-item:hover {
            background-color: #fff;
            border-color: var(--main_color);
        }

        .opcao-item input[type="checkbox"] {
            cursor: pointer;
            accent-color: var(--main_color);
            width: 20px;
            height: 20px;
            margin-top: 0.25rem;
            flex-shrink: 0;
        }

        .opcao-descricao {
            flex: 1;
        }

        .opcao-descricao label {
            margin-bottom: 0;
            font-weight: 600;
            color: var(--color1);
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .opcao-descricao small {
            color: #666;
            display: block;
            margin-top: 0.25rem;
        }

        .badge-admin {
            background-color: var(--main_color);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.7rem;
            font-weight: 600;
        }

        /* Erros */
        .alert-errors {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-errors ul {
            margin: 0;
            padding-left: 1.5rem;
        }

        .alert-errors li {
            margin-bottom: 0.5rem;
        }

        /* Botões */
        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            font-size: 1rem;
            font-weight: 600;
            border: none;
            border-radius: 0.5rem;
            background-color: var(--main_color);
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }

        .btn-submit:hover {
            background-color: #b87772;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(200, 146, 134, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Input file customizado */
        .form-control[type="file"] {
            padding: 0.5rem;
        }

        /* Responsivo */
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                padding: 1.5rem;
            }

            .radio-personalizacao {
                gap: 1rem;
            }

            .preview {
                justify-content: center;
            }

            .admin-info {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
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
                            <!-- Opção 1: Formato da Agenda -->
                            <div class="opcao-item">
                                <input 
                                    type="checkbox" 
                                    id="opt_formato" 
                                    name="personalizar_opcoes[]" 
                                    value="formato"
                                    {{ in_array('formato', old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                />
                                <div class="opcao-descricao">
                                    <label for="opt_formato">
                                        📅 Formato da Agenda
                                        <span class="badge-admin">ADMIN</span>
                                    </label>
                                    <small>Permitir que o cliente escolha entre "Com horas" e "Sem horas"</small>
                                </div>
                            </div>

                            <!-- Opção 2: Páginas Especiais -->
                            <div class="opcao-item">
                                <input 
                                    type="checkbox" 
                                    id="opt_paginas" 
                                    name="personalizar_opcoes[]" 
                                    value="paginas"
                                    {{ in_array('paginas', old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                />
                                <div class="opcao-descricao">
                                    <label for="opt_paginas">
                                        📄 Páginas Especiais
                                        <span class="badge-admin">ADMIN</span>
                                    </label>
                                    <small>Permitir que o cliente selecione páginas adicionais (Anotações, Objetivos, Hábitos, Financeiro)</small>
                                </div>
                            </div>

                            <!-- Opção 3: Texto da Capa -->
                            <div class="opcao-item">
                                <input 
                                    type="checkbox" 
                                    id="opt_texto_capa" 
                                    name="personalizar_opcoes[]" 
                                    value="texto_capa"
                                    {{ in_array('texto_capa', old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                />
                                <div class="opcao-descricao">
                                    <label for="opt_texto_capa">
                                        📝 Texto da Capa
                                        <span class="badge-admin">ADMIN</span>
                                    </label>
                                    <small>Permitir que o cliente escreva um texto personalizado na capa (máx. 30 caracteres)</small>
                                </div>
                            </div>

                            <!-- Opção 4: Acessório do Elástico -->
                            <div class="opcao-item">
                                <input 
                                    type="checkbox" 
                                    id="opt_acessorio" 
                                    name="personalizar_opcoes[]" 
                                    value="acessorio"
                                    {{ in_array('acessorio', old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                />
                                <div class="opcao-descricao">
                                    <label for="opt_acessorio">
                                        ⭕ Acessório do Elástico
                                        <span class="badge-admin">ADMIN</span>
                                    </label>
                                    <small>Permitir que o cliente escolha entre "Metálico" e "Acrílico"</small>
                                </div>
                            </div>

                            <!-- Opção 5: Cor das Argolas -->
                            <div class="opcao-item">
                                <input 
                                    type="checkbox" 
                                    id="opt_cor_argolas" 
                                    name="personalizar_opcoes[]" 
                                    value="cor_argolas"
                                    {{ in_array('cor_argolas', old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                />
                                <div class="opcao-descricao">
                                    <label for="opt_cor_argolas">
                                        🎨 Cor das Argolas
                                        <span class="badge-admin">ADMIN</span>
                                    </label>
                                    <small>Permitir que o cliente selecione entre Prata, Ouro, Preto, Rose Gold e Cobre</small>
                                </div>
                            </div>
                        </div>
                    </div>

                <div id="opcoes-docinhos" class="opcoes-personalizacao">
                    <!-- Exemplo de opções para Docinhos -->
                    <div class="opcoes-grid">
                        <div class="opcao-item">
                            <input type="checkbox" id="opt_tipo_de_chocolate" name="personalizar_opcoes[]" value="tipo_de_chocolate" />
                            <div class="opcao-descricao">
                                <label for="opt_tipo_de_chocolate">Tipo de Chocolate</label>
                                <small>Permitir escolher entre Chocolate negro, Chocolate braco, Chocolate com leite</small>
                            </div>
                        </div>

                        <div class="opcao-item">
                            <input type="checkbox" id="opt_embalagem" name="personalizar_opcoes[]" value="embalagem" />
                            <div class="opcao-descricao">
                                <label for="opt_embalagem">Nome na embalagem</label>
                                <small>Permitir que o cliente escreva um texto personalizado na embalagem (máx. 30 caracteres)</small>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>

            <!-- Botão Submit -->
            <button type="submit" class="btn-submit">💾 Guardar Produto</button>
        </form>
    </div>

    <script>
        /**
         * Verifica se a categoria selecionada é Papelaria (valor 1)
         * Se for, mostra o bloco de personalização admin
         */
        function verificaCategoria() {
            const select = document.getElementById('categoria');
            const blocoAdmin = document.getElementById('bloco-personalizacao-admin');
            const papelaria = document.getElementById('opcoes-papelaria');
            const docinhos = document.getElementById('opcoes-docinhos');

            if (select.value === '1') { // Papelaria
                blocoAdmin.classList.remove('hidden');
                papelaria.style.display = 'block';
                docinhos.style.display = 'none';
            } else if (select.value === '2') { // Docinhos
                blocoAdmin.classList.remove('hidden');
                papelaria.style.display = 'none';
                docinhos.style.display = 'block';
            } else {
                blocoAdmin.classList.add('hidden');
                papelaria.style.display = 'none';
                docinhos.style.display = 'none';
                // Reset checkboxes
                document.querySelectorAll('input[name^="personalizar_opcoes"]').forEach(cb => cb.checked = false);
            }
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
</body>
</html>
