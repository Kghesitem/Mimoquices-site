/**
 * Mimoquices - Gestão de Formulários de Produtos (Criar e Editar Unificado)
 */

let ficheirosSelecionados = [];

// Estilos dinâmicos para a gestão de imagens (usados no preview de ambas as páginas)
const estiloBotaoRemover = 'position: absolute; top: 5px; right: 5px; border: none; background: rgba(0,0,0,0.7); color: white; border-radius: 50%; cursor: pointer; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 12px; line-height: 1; padding: 0; z-index: 10; opacity: 0; transition: opacity 0.15s ease; pointer-events: none;';
const estiloCardImagem   = 'position: relative; display: inline-block; margin: 8px; width: 120px; height: 120px;';

// Calcula a altura necessária baseado no texto interno das textareas
function autoExpandTextarea(textarea) {
    if (!textarea) return;
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

// Mostra/Esconde o bloco de administração dependendo da categoria selecionada
function verificaCategoria() {
    const select = document.getElementById('categoria');
    const blocoAdmin = document.getElementById('bloco-personalizacao-admin');

    if (!select || !blocoAdmin) return;

    if (select.value !== '') {
        blocoAdmin.style.display = 'block';
    } else {
        blocoAdmin.style.display = 'none';
        document.querySelectorAll('input[name^="personalizar_opcoes"]').forEach(cb => cb.checked = false);
    }

    const categoriaSelecionada = select.value;
    const opcoes = document.querySelectorAll('.opcao-item');

    opcoes.forEach(opcao => {
        const datasetCategorias = opcao.dataset.categorias || '';
        const categorias = datasetCategorias.split(',').map(c => c.trim());

        if (!categoriaSelecionada || categorias.includes(categoriaSelecionada)) {
            opcao.style.display = 'flex';
        } else {
            opcao.style.display = 'none';
            const checkbox = opcao.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = false;
        }
    });
}

// Ativa ou desativa a exibição das checkboxes de personalização
function toggleOpcoes() {
    const sim = document.querySelector('input[name="pode_personalizar"][value="Sim"]');
    const opcoesDiv = document.getElementById('opcoes-personalizacao');

    if (!sim || !opcoesDiv) return;

    if (sim.checked) {
        opcoesDiv.style.display = 'block';
    } else {
        opcoesDiv.style.display = 'none';
        document.querySelectorAll('input[name="personalizar_opcoes[]"]').forEach(cb => {
            cb.checked = false;
        });
    }
}

// Controla o placeholder de "Nenhuma imagem selecionada"
function verificarSeVazio() {
    const emptyPreview = document.getElementById('preview-empty') || document.querySelector('.preview-empty');
    const containerExistente = document.getElementById('preview-existente');
    const containerNovo = document.getElementById('preview-novo');
    const previewGeral = document.getElementById('preview'); // Suporte para a estrutura do Criar
    
    if (!emptyPreview) return;

    // Verifica elementos filhos nos containers disponíveis
    const temExistentes = containerExistente && containerExistente.children.length > 0;
    const temNovas = containerNovo && containerNovo.children.length > 0;
    const temGeral = previewGeral && previewGeral.querySelectorAll('div').length > 0;

    if (temExistentes || temNovas || temGeral) {
        emptyPreview.style.display = 'none';
    } else {
        emptyPreview.style.display = 'block';
    }
}

// Remove uma imagem recém-selecionada (Funciona no Criar e no Editar)
function removerImagem(index) {
    const input = document.getElementById('images');
    if (!input) return;

    // Remove o ficheiro da nossa lista em memória
    ficheirosSelecionados.splice(index, 1);

    // Atualiza o input file real do HTML recorrendo ao DataTransfer da API do browser
    const dataTransfer = new DataTransfer();
    ficheirosSelecionados.forEach(file => dataTransfer.items.add(file));
    input.files = dataTransfer.files;

    // Força a atualização do preview visual na página
    previewImages(input);
}

// Gera o preview das novas imagens selecionadas no input file (Unificado com suporte a remoção)
function previewImages(input) {
    // Tentamos encontrar os sub-containers do Editar. Se não existirem, usamos o #preview do Criar.
    let containerDestino = document.getElementById('preview-novo') || document.getElementById('preview');
    if (!containerDestino) return;
    
    containerDestino.innerHTML = ''; 
    const files = Array.from(input.files);
    ficheirosSelecionados = files;

    // Se no Criar não existir o bloco fixo de "vazio", criamos o placeholder dinamicamente
    if (files.length === 0) {
        containerDestino.innerHTML = '<div class="preview-empty" id="preview-empty">Nenhuma imagem selecionada</div>';
        return;
    }

    files.forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Criamos o cartão da imagem com posição relativa para albergar o botão por cima
                const container = document.createElement('div');
                container.style.cssText = estiloCardImagem;

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; border-radius: 10px; border: 2px solid #6c757d;';

                // Botão de remoção individual com o X
                const btn = document.createElement('button');
                btn.innerHTML = '❌';
                btn.type = 'button';
                btn.style.cssText = estiloBotaoRemover;

                // Efeito Hover: Mostrar o botão apenas quando o rato está por cima do cartão
                container.addEventListener('mouseenter', () => {
                    btn.style.opacity = '1';
                    btn.style.pointerEvents = 'auto';
                });
                container.addEventListener('mouseleave', () => {
                    btn.style.opacity = '0';
                    btn.style.pointerEvents = 'none';
                });

                // Evento de clique para apagar do input e da vista
                btn.onclick = function() {
                    removerImagem(index);
                };

                container.appendChild(img);
                container.appendChild(btn);
                containerDestino.appendChild(container);
                verificarSeVazio();
            };
            reader.readAsDataURL(file);
        }
    });
}

// Carrega as imagens antigas vindas do servidor (Exclusivo da View de Editar)
function carregarImagensExistentes() {
    const containerExistente = document.getElementById('preview-existente');
    if (!containerExistente || typeof imagensExistentes === 'undefined') return;
    
    containerExistente.innerHTML = ''; 

    imagensExistentes.forEach((foto, index) => {
        const container = document.createElement('div');
        container.style.cssText = estiloCardImagem;

        const img = document.createElement('img');
        img.src = foto.url;
        img.title = foto.nome; 
        img.alt = foto.nome;
        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; border-radius: 10px; border: 2px solid #ddd;';

        const btn = document.createElement('button');
        btn.innerHTML = '❌';
        btn.type = 'button';
        btn.style.cssText = estiloBotaoRemover;

        container.addEventListener('mouseenter', () => {
            btn.style.opacity = '1';
            btn.style.pointerEvents = 'auto';
        });
        container.addEventListener('mouseleave', () => {
            btn.style.opacity = '0';
            btn.style.pointerEvents = 'none';
        });

        btn.onclick = function(e) {
            e.preventDefault();
            const formEdit = document.getElementById('form-edit');
            if (formEdit) {
                const inputDelete = document.createElement('input');
                inputDelete.type = 'hidden';
                inputDelete.name = 'fotos_remover[]';
                inputDelete.value = foto.path; 
                formEdit.appendChild(inputDelete);
            }

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

// Inicialização de scripts no carregamento inicial da página
document.addEventListener('DOMContentLoaded', function() {
    const blocoAdmin = document.getElementById('bloco-personalizacao-admin');
    const opcoesDiv = document.getElementById('opcoes-personalizacao');
    const radioSim = document.querySelector('input[name="pode_personalizar"][value="Sim"]');
    
    if (blocoAdmin) blocoAdmin.style.display = 'none';
    
    if (opcoesDiv && radioSim) {
        opcoesDiv.style.display = radioSim.checked ? 'block' : 'none';
    }
    
    verificaCategoria();
    
    // Configura e ativa o auto-expand das caixas de texto longas
    const textareas = document.querySelectorAll('.textarea-auto-expand');
    textareas.forEach(textarea => {
        autoExpandTextarea(textarea);
        textarea.addEventListener('input', function() {
            autoExpandTextarea(this);
        });
    });

    // Se existir a variável global de imagens, carrega-as (Cenário de Edição)
    if (typeof imagensExistentes !== 'undefined') {
        carregarImagensExistentes();
    } else {
        verificarSeVazio();
    }
});