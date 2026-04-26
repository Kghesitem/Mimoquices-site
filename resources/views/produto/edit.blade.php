@include('partial.header')
<head>
    <title>Editar Produto - Mimoquices</title>
</head>

<a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}">
        ← Voltar
    </a>
<body>
    <main class="profile-page py-5">
    <div class="container">
    <div class="form-container">
        <h1>Editar Produto</h1>

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

        <form id="form-edit"method="post" action="{{ route('produto.update', ['produto' => $produto]) }}" enctype="multipart/form-data">
            @csrf
            @method('put')

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
                    value="{{$produto->titulo}}"
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
                >{{$produto->descricao}}</textarea>
            </div>

            <div class="form-group">
                <label for="conteudo">Conteúdo</label>
                <textarea 
                    id="conteudo"
                    class="form-control" 
                    name="conteudo" 
                    placeholder="Conteudo do produto..."
                >{{$produto->conteudo}}</textarea>
            </div>

            <div class="form-group">
                <label for="detalhes">Detalhes</label>
                <textarea 
                    id="detalhes"
                    class="form-control" 
                    name="detalhes" 
                    placeholder="Detalhes do produto..."
                >{{$produto->detalhes}}</textarea>
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
                    <option value="{{ $tipo->id }}" {{ $produto->tipo_prod == $tipo->id ? 'selected' : '' }}>
                        {{ $tipo->Categoria }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Input de imagens -->
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
                />
                <small class="text-muted">Pode selecionar várias imagens. Tamanho máximo: 5MB por imagem.</small>
               <div id="preview" class="preview">
                    <div id="preview-existente"></div>
                    <div id="preview-novo"></div>
                    <div id="preview-empty center" class="preview-empty">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-image" viewBox="0 0 16 16">
                        <path d="M8.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                        <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v8l-2.083-2.083a.5.5 0 0 0-.76.063L8 11 5.835 9.7a.5.5 0 0 0-.611.076L3 12z"/>
                    </svg>

                    Nenhuma imagem selecionada</div>
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
                                @if ($produto->pode_personalizar== 'Sim') 
                                    {{ !old('pode_personalizar') ? 'checked' : '' }}
                                @endif
                            />
                            Sim - permitir personalização
                        </label>
                        <label>
                            <input 
                                type="radio" 
                                name="pode_personalizar" 
                                value="Não"
                                onchange="toggleOpcoes()"
                                @if ($produto->pode_personalizar !== 'Sim') 
                                    {{ !old('pode_personalizar') ? 'checked' : '' }}
                                @endif
                                
                            />
                            Não
                        </label>
                    </div>
                </div>
               
                <!-- Opções de Personalização (aparecem se escolher Sim) -->
                <div id="opcoes-personalizacao" {{ old('pode_personalizar') == 'Sim' ? 'class="visible"' : '' }}  @if ($produto->pode_personalizar == 'Sim')  class="visible" @endif >
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
                                        
                                        @if($produto->personalizar_opcoes == null)
                                            
                                        @else
                                        {{ in_array($personalizacao->id, old('personalizar_opcoes', [])) ? 'checked' : '' }}
                                            @foreach (json_decode($produto->personalizar_opcoes) as $opcao)
                                                @if ($opcao == $personalizacao->id)
                                                    checked
                                                @endif
                                                
                                            @endforeach
                                        @endif
                                        
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
                const categorias = opcao.dataset.categorias.split(',').map(c => c.trim());

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



    let ficheirosSelecionados = [];


const estiloBotaoRemover = 'position: absolute; top: 5px; right: 5px; border: none; background: rgba(0,0,0,0.6); color: white; border-radius: 50%; cursor: pointer; width: 25px; height: 25px; display: flex; align-items: center; justify-content: center; font-size: 14px; line-height: 1; padding: 0;';

    /**
     * Carrega as imagens recentemente colocadas  
     */
    function previewImages(input) {
    const containerNovo = document.getElementById('preview-novo');
    containerNovo.innerHTML = ''; 
    
    const files = Array.from(input.files);
    ficheirosSelecionados = files;

    verificarSeVazio();

    files.forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.createElement('div');
                container.className = 'img-container'; // Usa a classe CSS

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #6c757d;';

                const btn = document.createElement('button');
                btn.innerHTML = '❌';
                btn.type = 'button';
                btn.className = 'btn-remover-foto'; // Usa a classe CSS

                btn.onclick = function() {
                    removerImagem(index);
                };

                container.appendChild(img);
                container.appendChild(btn);
                containerNovo.appendChild(container);
            };
            reader.readAsDataURL(file);
        }
    });
}

    /**
     * Carregas as imagens que estão na base ded dados
     */
    function carregarImagensExistentes() {
    const containerExistente = document.getElementById('preview-existente');
    if (!containerExistente) return;
    
    containerExistente.innerHTML = ''; 

    imagensExistentes.forEach((foto, index) => {
        const container = document.createElement('div');
        container.className = 'img-container'; // Usa a classe CSS

        const img = document.createElement('img');
        img.src = foto.url;
        img.title = foto.nome; 
        img.alt = foto.nome;
        img.style.cssText = 'width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 2px solid #ddd;';

        const btn = document.createElement('button');
        btn.innerHTML = '❌';
        btn.type = 'button';
        btn.className = 'btn-remover-foto'; // Usa a classe CSS

        btn.onclick = function(e) {
            e.preventDefault();
            const inputDelete = document.createElement('input');
            inputDelete.type = 'hidden';
            inputDelete.name = 'fotos_remover[]';
            inputDelete.value = foto.path; 
            document.getElementById('form-edit').appendChild(inputDelete);

            container.remove();
            imagensExistentes.splice(index, 1);
            verificarSeVazio();
        };

        container.appendChild(img);
        container.appendChild(btn);
        containerExistente.appendChild(container);
    });
    
    verificarSeVazio();
}
    
    /**
     * Se nenhuma imagem estivcer na base de dados ou foi carregada para o site ele mostra que está vazio 
     */
    function verificarSeVazio() {
        const emptyMsg = document.getElementById('preview-empty');
        const temExistentes = imagensExistentes.length > 0;
        const temNovas = ficheirosSelecionados.length > 0;

        if (temExistentes || temNovas) {
            emptyMsg.style.display = 'none';
        } else {
            emptyMsg.style.display = 'block';
        }
    }

    /**
     * faz o botão remove remover do preview
     */
    function removerImagem(index) {
        ficheirosSelecionados.splice(index, 1);

        const input = document.querySelector('input[type="file"]');
        const dataTransfer = new DataTransfer();

        ficheirosSelecionados.forEach(file => {
            dataTransfer.items.add(file);
        });

        input.files = dataTransfer.files;

        previewImages(input);
    }

    /**
     * foreach para ir buscar todos as fotos que estão na base de dados 
     */
    @if(isset($fotos))
        const imagensExistentes = [
            @foreach($fotos as $foto)
            {
                nome:'{{ $foto ->img_original}}',
                url: '{{ asset('storage/' . $foto->img_cod) }}',
                path: '{{ $foto->img_cod }}'
            },
            @endforeach
        ];
    @else
        const imagensExistentes = [];
    @endif

    /**
     * Carrega as funcões verificar e carregar no load da página
     */

    document.addEventListener('DOMContentLoaded', () => {
        verificaCategoria();
        carregarImagensExistentes();
    });
    </script>

