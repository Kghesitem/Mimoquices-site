
<div class="dashboard-mimo" style="padding: 2rem;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; max-width: 1200px; margin: 0 auto 2rem;">
        <h1 style="color: var(--color1); margin: 0;">📦 Gestão de Produtos</h1>
        <button id="toggleViewBtn" class="tab-button active">
            <i class="bi bi-grid-3x3-gap"></i> Ver em Cards
        </button>
    </div>


    <div class="card mb-2 border-0 shadow-sm" style="border-radius: 1.5rem; max-width: 73%; margin: 0 auto 2rem;">
        <div class="card-body p-3 d-flex flex-wrap gap-3 align-items-center" style="background-color: white; border-radius: 1.5rem; border: 1px solid var(--color-border);">
            
            <div class="flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0" style="border-radius: 1rem 0 0 1rem; border-color: var(--color-border);">
                        <i class="bi bi-search" style="color: var(--main_color);"></i>
                    </span>
                    <input type="text" id="pesquisa" class="form-control border-start-0 ps-0" placeholder="Pesquisar produto..." style="border-radius: 0 1rem 1rem 0; border-color: var(--color-border); box-shadow: none;">
                </div>
            </div>

            <select id="filtroTipos" class="form-select w-auto" style="border-radius: 1rem; border-color: var(--color-border); appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 0.5rem;">">
                <option value="">Todas as Categorias</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->Categoria }}</option>
                @endforeach
            </select>
            <select id="visibilidades" class="form-select w-auto" style="border-radius: 1rem; border-color: var(--color-border); appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 0.5rem;">">
                <option value="">Todas as Visibilidades</option>
                <option value="1">Visível</option>
                <option value="0">Oculto</option>
            </select>
            <select id="favoritos" class="form-select w-auto" style="border-radius: 1rem; border-color: var(--color-border); appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 0.5rem;">">
                <option value="">Favoritos e não favoritos</option>
                <option value="1">Favoritos</option>
                <option value="0">Não Favoritos</option>
            </select>

        </div>
    </div>
</div>




<div id="tableView" class="profile-card container-fluid p-0 mb-4" style="display: none; background-color: white; border: 2px solid var(--main_color); overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover m-0" style="font-family: inherit;">
            <thead style="background-color: var(--main_color_light);">
                <tr style="border-bottom: 2px solid var(--main_color);">
                    <th class="ps-4 py-3" style="color: var(--color1); font-weight: 700;">Favorito</th>
                    <th class="ps-4 py-3" style="color: var(--color1); font-weight: 700;">Produto</th>
                    <th class="py-3" style="color: var(--color1); font-weight: 700;">Categoria</th>
                    <th class="py-3 text-center" style="color: var(--color1); font-weight: 700;">Visibilidade</th>
                    <th class="py-3 text-center" style="color: var(--color1); font-weight: 700;">Criação</th>
                    <th class="py-3 text-center" style="color: var(--color1); font-weight: 700;">Atualização</th>
                    <th class="pe-4 py-3 text-end" style="color: var(--color1); font-weight: 700;">Ações</th>
                </tr>
            </thead>
            <tbody>
                    <tr id="noResultsTable" style="display: none;">
                        <td colspan="7" class="text-center py-5" style="color: var(--color-muted); font-style: italic;">
                            🔍 Nenhum produto corresponde aos filtros.
                        </td>
                    </tr>
                @if($produtos->isEmpty())
                    <tr>
                    <td colspan="6" class="text-center py-4" data-produto-id="{{ $produto->id }}" style="color: var(--color-muted); font-style: italic;">Nenhum produto encontrado.</td>
                    </tr>
                @endif
                @foreach ($produtos as $produto)
                <tr class="align-middle item-produto" data-visivel="{{ $produto->disponivel }}" data-tipo="{{ $produto->tipo_prod }}" style="border-bottom: 1px solid var(--color-border);">
                    <td class="ps-4 font-weight-700">
                        <div class="form-check">
                            <input 
                                type="checkbox"
                                name="favorito"
                                class="form-check-input d-none favorito"
                                
                                id="favorito-table-{{ $produto->id }}"
                                data-produto-id="{{ $produto->id }}"
                                @if($produto->favorito === 1) checked @endif
                            >

                            <label for="favorito-table-{{ $produto->id }}" class="cursor-pointer">
                                <i class="bi 
                                    @if($produto->favorito === 1) bi-star-fill text-warning 
                                    @else bi-star text-secondary 
                                    @endif
                                    estrela-icon"
                                    style="cursor: pointer;"
                                ></i>
                            </label>
                        </div>
                    </td>
                    <td class="ps-4 font-weight-700" ><a href="/produtos/{{$produto->url_completo}}" style="color: var(--color1); font-weight: 700; text-decoration:none">{{ $produto->titulo }}</a></td>
                    <td>
                        <span class="badge" style="background-color: var(--main_color_light); color: var(--main_color); border: 1px solid var(--main_color);">
                            @foreach ($tipos as $tipo)
                                @if ($produto->tipo_prod === $tipo->id) {{ $tipo->Categoria }} @endif
                            @endforeach
                        </span>
                    </td>
                    <td class="text-center">
                        <select class="form-select-personalizacao formato_agenda py-1 px-2" data-produto-id="{{ $produto->id }}" style="width: auto; display: inline-block;">
                            <option value="0" {{ $produto->disponivel == 0 ? 'selected' : '' }}>🔴 Não Visível</option>
                            <option value="1" {{ $produto->disponivel == 1 ? 'selected' : '' }}>🟢 Visível</option>
                        </select>
                    </td>
                    <td class="text-center text-muted" style="font-size: 0.95rem;"> {{ $produto->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center text-muted" style="font-size: 0.95rem;">
                        {{ $produto->updated_at == $produto->created_at ? 'Sem atualizações' : $produto->updated_at->format('d/m/Y H:i') }}
                    </td>
                        <td class="d-flex gap-1 flex-column">
                            {{-- Botão Editar --}}
                            <a href="{{ route('produto.edit', ['produto' => $produto]) }}" 
                            class="tab-button text-center" 
                            style="padding: 6px 12px; font-size: 0.85rem; text-decoration: none; width: 100%; display: block;">
                                ✏️ Editar
                            </a>

                            {{-- Botão Eliminar --}}
                            <form action="{{ url('produto/'.$produto->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Tem certeza que deseja eliminar este produto?')"
                                style="width: 100%; margin: 0;"> {{-- Garante que o form ocupe 100% --}}
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="tab-button" 
                                        style="padding: 6px 12px; font-size: 0.85rem; border-color: var(--color-error); color: var(--color-error); background: transparent; width: 100%; cursor: pointer;">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </td>                 
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


<div id="cardView" class="container-fluid px-0" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center;">
        <div id="noResultsCard" class="text-center py-5 w-100" style="display: none; color: var(--color-muted); font-style: italic;">
            🔍 Nenhum produto corresponde aos filtros.
        </div>    

    @if($produtos->isEmpty())
        <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
            Nenhum produto encontrado.
        </div>
    @endif
    @foreach ($produtos as $produto)
        <div class="dash-card item-produto" data-visivel="{{ $produto->disponivel }}" data-tipo="{{ $produto->tipo_prod }}" style="flex: 0 1 280px; min-width: 250px; background-color: white; border: 1px solid var(--color-border); display: flex; flex-direction: column; padding: 1.5rem; border-radius: 1.5rem;">
            
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div style="max-width: 80%;">
                

                        <input 
                            type="checkbox"
                            name="favorito"
                            class="form-check-input d-none favorito"
                            id="favorito-card-{{ $produto->id }}"
                            data-produto-id="{{ $produto->id }}"
                            @if($produto->favorito === 1) checked @endif
                        >

                        <label for="favorito-card-{{ $produto->id }}" class="cursor-pointer">
                            <i class="bi 
                                @if($produto->favorito === 1) bi-star-fill text-warning 
                                @else bi-star text-secondary 
                                @endif
                                estrela-icon"
                                style="cursor: pointer;"
                            ></i>
                        </label>




                    <h3><a href="/produtos/{{$produto->url_completo}}"style="color: var(--main_color); font-size: 1.1rem; margin: 0; font-family: Georgia, serif; text-decoration:none" >{{ $produto->titulo }}</a></h3>
                    <small class="text-muted" style="font-family: 'Poppins', sans-serif;">
                        @foreach ($tipos as $tipo)
                            @if ($produto->tipo_prod === $tipo->id) {{ $tipo->Categoria }} @endif
                        @endforeach
                    </small>
                </div>
                <span class="status-dot" style="background-color: {{ $produto->disponivel ? '#4ade80' : '#dc3545' }};"></span>
            </div>

            <div class="form-group-personalizacao mb-3">
                <label class="small fw-bold mb-1" style="display: block;">Estado de Exibição</label>
                <select class="form-select-personalizacao formato_agenda py-1" data-produto-id="{{ $produto->id }}">
                    <option value="0" {{ $produto->disponivel == 0 ? 'selected' : '' }}>🔴 Não Visível</option>
                    <option value="1" {{ $produto->disponivel == 1 ? 'selected' : '' }}>🟢 Visível</option>
                </select>
            </div>

            <div class="mt-auto pt-2" style="border-top: 1px dashed var(--color-border);">
                <div style="font-size: 0.75rem; color: #888; margin-bottom: 10px;">
                    <div class="d-flex align-items-center mb-1">
                        <span class="me-1">📅</span> <b>Criação: </b> {{ $produto->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-1">🔄</span> <b>Edição: </b> {{ $produto->updated_at == $produto->created_at ? '-' : $produto->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <div class="d-flex gap-2 flex-column">
                    {{-- { route('produto.edit', ['produto' => $produto]) } --}}
                    <a href="{{ route('produto.edit', ['produto' => $produto]) }}" class="btn-personalizar w-100 d-block text-center text-decoration-none" style="background-color: var(--main_color); font-size: 0.9rem;">
                        Editar Produto
                    </a>
                    {{-- {{ url('produto/'.$produto->id) }} --}}
                    <form action="{{ url('produto/'.$produto->id) }}" method="post" class="flex-grow-1" onsubmit="return confirm('Eliminar definitivamente?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-personalizar w-100 py-2" style="background-color: var(--color-error); font-size: 0.9rem; margin-top: 0;">
                            Eliminar
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    @endforeach
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

    $(document).ready(function() {
    const pesquisa = document.getElementById('pesquisa');
    const filtroTipos = document.getElementById('filtroTipos');
    const visivel = document.getElementById('visibilidades');
    const favoritos = document.getElementById('favoritos');

    function filtrarProdutos() {
        const texto = pesquisa.value.toLowerCase().trim();
        const tipoId = filtroTipos.value;
        const visivelId = visivel.value;
        const favoritoId = favoritos.value;
        let encontrouAlgo = false;

        const itens = document.querySelectorAll('.item-produto');

        itens.forEach(item => {
            const titulo = item.querySelector('h3, td:nth-child(2)')?.textContent.toLowerCase() || "";
            const itemTipo = item.getAttribute('data-tipo');
            
            const selectVisivel = item.querySelector('.formato_agenda');
            const itemVisivel = selectVisivel ? selectVisivel.value : "0";
            
            const itemFavorito = item.querySelector('.favorito')?.checked ? "1" : "0";

            const matchTexto = titulo.includes(texto);
            const matchTipo = tipoId === "" || itemTipo === tipoId;
            const matchVisivel = visivelId === "" || itemVisivel === visivelId;
            const matchFavorito = favoritoId === "" || itemFavorito === favoritoId;

            if (matchTexto && matchTipo && matchVisivel && matchFavorito) {
                item.style.setProperty('display', '', 'important');
                encontrouAlgo = true;
            } else {
                item.style.setProperty('display', 'none', 'important');
            }
        });

        const msgTabela = document.getElementById('noResultsTable');
        const msgCard = document.getElementById('noResultsCard');

        if (encontrouAlgo) {
            if(msgTabela) msgTabela.style.display = 'none';
            if(msgCard) msgCard.style.display = 'none';
        } else {
            // Só mostra a mensagem se houver uma busca ativa ou filtro
            // para não confundir com a lista vazia original do banco de dados
            if(msgTabela) msgTabela.style.display = 'table-row';
            if(msgCard) msgCard.style.display = 'block';
        }
    }

        pesquisa.addEventListener('input', filtrarProdutos);
        filtroTipos.addEventListener('change', filtrarProdutos);
        visivel.addEventListener('change', filtrarProdutos);
        favoritos.addEventListener('change', filtrarProdutos);
    });


    $(document).ready(function() {
        const toggleBtn = $('#toggleViewBtn');
        const tableView = $('#tableView');
        const cardView = $('#cardView');


        tableView.show();
        cardView.hide();
        toggleBtn.html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');

        toggleBtn.on('click', function() {
            // Verificamos se a tabela está visível no momento do clique
            const isShowingTable = tableView.is(':visible');

            if (isShowingTable) {
                tableView.hide();
                cardView.fadeIn().css('display', 'flex'); 
                $(this).html('<i class="bi bi-table"></i> Ver em Tabela');
            } else {
                cardView.hide();
                tableView.fadeIn();


                $(this).html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');
            }
        });
    });

    $(document).on('change', '.formato_agenda', function() {
        const $select = $(this);
        const produtoId = $select.data('produto-id');
        const novoStatus = $select.val();

        // Feedback visual usando a cor de borda do seu CSS
        $select.css('border-color', 'var(--main_color)');

        $.ajax({
            url: '/produto/' + produtoId + '/visivel',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                disponivel: novoStatus
            },
            success: function(response) {
                if(response.success) {
                    // Sincroniza o valor em ambas as vistas (Card e Tabela)
                    $(`.formato_agenda[data-produto-id="${produtoId}"]`).val(novoStatus);
                    
                    // Se for no card, atualiza a cor do status-dot dinamicamente
                    const dot = $select.closest('.dash-card').find('.status-dot');
                    if(novoStatus == "1") {
                        dot.css({'background-color': '#4ade80', 'box-shadow': '0 0 8px #4ade80'});
                    } else {
                        dot.css({'background-color': '#dc3545', 'box-shadow': '0 0 8px #dc3545'});
                    }
                }
            },
            error: function() {
                // Estilo de erro baseado no seu CSS
                $select.css('border-color', 'var(--color-error)');
                alert('Erro ao atualizar. Por favor, tente novamente.');
            }
        });
    });

    $(document).on('change', '.favorito', function() {
        const $check = $(this);
        const produtoId = $check.data('produto-id');
        const novoStatus = $check.is(':checked') ? 1 : 0;

        const icon = $(this).next('label').find('i')[0];


                if (this.checked) {
            icon.classList.remove('bi-star', 'text-secondary');
            icon.classList.add('bi-star-fill', 'text-warning');
        } else {
            icon.classList.remove('bi-star-fill', 'text-warning');
            icon.classList.add('bi-star', 'text-secondary');
        }

        $.ajax({
            url: '/produto/' + produtoId + '/favorito',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                favorito: novoStatus
            },
            success: function(response) {
                $(`.favorito[data-produto-id="${produtoId}"]`).each(function() {
                    const icon = $(this).next('label').find('i');

                    if (novoStatus === 1) {
                        icon.removeClass('bi-star text-secondary')
                            .addClass('bi-star-fill text-warning');
                    } else {
                        icon.removeClass('bi-star-fill text-warning')
                            .addClass('bi-star text-secondary');
                    }
                });
            },
            error: function() {
                $check.css('border-color', 'var(--color-error)');
                alert('Erro ao atualizar. Por favor, tente novamente.');
            }
        });
    });

    
</script>