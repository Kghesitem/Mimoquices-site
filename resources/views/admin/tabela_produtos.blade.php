<div class="dashboard-mimo" style="padding: 2rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; max-width: 1200px; margin: 0 auto 2rem;">
            <h4 style="color: var(--color1); margin: 0;"><x-heroicon-o-numbered-list style=" width: 3rem; height: 3rem; color:var(--main_color);"/> Lista de Produtos</h4>
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

            <select id="filtroTipos" class="form-select w-auto" style="border-radius: 1rem; border-color: var(--color-border); appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 0.5rem;">
                <option value="">Todas as Categorias</option>
                @foreach($tipos as $tipo)
                    <option value="{{ $tipo->id }}">{{ $tipo->Categoria }}</option>
                @endforeach
            </select>
            <select id="visibilidades" class="form-select w-auto" style="border-radius: 1rem; border-color: var(--color-border); appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 0.5rem;">
                <option value="">Todas as Visibilidades</option>
                <option value="1">Visível</option>
                <option value="0">Oculto</option>
            </select>
            <select id="destaques" class="form-select w-auto" style="border-radius: 1rem; border-color: var(--color-border); appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: none; padding-right: 0.5rem;">
                <option value="">destaques e não destaques</option>
                <option value="1">destaques</option>
                <option value="0">Não destaques</option>
            </select>

        </div>
    </div>
</div>

<div id="tableView" class="profile-card container-fluid p-0 mb-4" style="display: none; background-color: white; border: 2px solid var(--main_color); overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover m-0" style="font-family: inherit;">
            <thead style="background-color: var(--main_color_light);">
                <tr style="border-bottom: 2px solid var(--main_color);">
                    <th class="ps-4 py-3" style="color: var(--color1); font-weight: 700;">destaque</th>
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
                            <x-heroicon-s-magnifying-glass style="width: 2rem; height: 2rem;"/> Nenhum produto corresponde aos filtros.
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
                                name="destaque"
                                class="form-check-input d-none destaque"
                                id="destaque-table-{{ $produto->id }}"
                                data-produto-id="{{ $produto->id }}"
                                @if($produto->destaque === 1) checked @endif
                            >

                            <label for="destaque-card-{{ $produto->id }}" class="cursor-pointer">
                                {{-- Texto invisível para os utilizadores, mas legível para o SonarQube e leitores de ecrã --}}
                                <span class="visually-hidden">Destacar produto {{ $produto->titulo ?? '' }}</span>

                                <i class="bi
                                    @if($produto->destaque === 1) bi-star-fill text-warning
                                    @else bi-star text-secondary
                                    @endif
                                    estrela-icon"
                                style="cursor: pointer;"
                                ></i>
                            </label>
                        </div>
                    </td>
                    <td class="ps-4 font-weight-700" ><a href="{{ route('produto.show', $produto->url_completo) }}" style="color: var(--color1); font-weight: 700; text-decoration:none">{{ $produto->titulo }}</a></td>
                    <td>
                        <span class="badge" style="background-color: var(--main_color_light); color: var(--main_color); border: 1px solid var(--main_color);">
                            @foreach ($tipos as $tipo)
                                @if ($produto->tipo_prod === $tipo->id) {{ $tipo->Categoria }} @endif
                            @endforeach
                        </span>
                    </td>
                    <td class="text-center">
                        <select class="form-select-personalizacao formato_agenda py-1 px-2" data-produto-id="{{ $produto->id }}" style="width: auto; display: inline-block;">
                            <option value="0" {{ $produto->disponivel == 0 ? 'selected' : '' }}>Não Visível</option>
                            <option value="1" {{ $produto->disponivel == 1 ? 'selected' : '' }}> Visível</option>
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
                                <x-heroicon-s-pencil  style=" width: 1rem; height: 1rem; color:black"/> Editar
                            </a>

                            {{-- Botão Eliminar (Tabela) --}}
                            <form action="{{ url('produto/'.$produto->id) }}"
                                method="POST"
                                class="form-eliminar-produto"
                                style="width: 100%; margin: 0;">
                                @csrf
                                @method('DELETE')
                                <button type="button"
                                        class="tab-button btn-eliminar"
                                        style="padding: 6px 12px; font-size: 0.85rem; border-color: var(--color-error); color: var(--color-error); background: transparent; width: 100%; cursor: pointer;">
                                    <x-heroicon-c-trash  style=" width: 1rem; height: 1rem; color:red"/> Eliminar
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
            <x-heroicon-s-magnifying-glass style="width: 2rem; height: 2rem;"/> Nenhum produto corresponde aos filtros.
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
                            name="destaque"
                            class="form-check-input d-none destaque"
                            id="destaque-card-{{ $produto->id }}"
                            data-produto-id="{{ $produto->id }}"
                            @if($produto->destaque === 1) checked @endif
                        >

                        <label for="destaque-card-{{ $produto->id }}" class="cursor-pointer">
                            {{-- Texto acessível adicionado para o SonarQube e leitores de ecrã --}}
                            <span class="visually-hidden">Alternar destaque do produto {{ $produto->titulo ?? '' }}</span>

                            <i class="bi
                                @if($produto->destaque === 1) bi-star-fill text-warning
                                @else bi-star text-secondary
                                @endif
                                estrela-icon"
                               style="cursor: pointer;"
                            ></i>
                        </label>

                    <h3><a href="{{ route('produto.show', $produto->url_completo) }}" style="color: var(--main_color); font-size: 1.1rem; margin: 0; font-family: Georgia, serif; text-decoration:none" >{{ $produto->titulo }}</a></h3>
                    <small class="text-muted" style="font-family: 'Poppins', sans-serif;">
                        @foreach ($tipos as $tipo)
                            @if ($produto->tipo_prod === $tipo->id) {{ $tipo->Categoria }} @endif
                        @endforeach
                    </small>
                </div>
                <span class="status-dot" style="background-color: {{ $produto->disponivel ? '#4ade80' : '#dc3545' }};"></span>
            </div>

            <div class="form-group-personalizacao mb-3">
                {{-- Associado o "for" ao id do select abaixo --}}
                <label for="estado-exibicao-{{ $produto->id }}" class="small fw-bold mb-1" style="display: block;">Estado de Exibição</label>

                {{-- Adicionado o atributo id correspondente --}}
                <select id="estado-exibicao-{{ $produto->id }}" class="form-select-personalizacao formato_agenda py-1" data-produto-id="{{ $produto->id }}">
                    <option value="0" {{ $produto->disponivel == 0 ? 'selected' : '' }}> Não Visível</option>
                    <option value="1" {{ $produto->disponivel == 1 ? 'selected' : '' }}> Visível</option>
                </select>
            </div>

            <div class="mt-auto pt-2" style="border-top: 1px dashed var(--color-border);">
                <div style="font-size: 0.75rem; color: #888; margin-bottom: 10px;">
                    <div class="d-flex align-items-center mb-1">
                        <span class="me-1"><x-heroicon-o-calendar style="width: 0.95rem; height: 0.95rem; margin-right: 0.25rem; color: #666;" /></span> <b>Criação: </b> {{ $produto->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-1"><x-heroicon-o-arrow-path style="width: 0.95rem; height: 0.95rem; margin-right: 0.25rem; color: #666;" /></span> <b>Edição: </b> {{ $produto->updated_at == $produto->created_at ? '-' : $produto->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <div class="d-flex gap-2 flex-column">
                    <a href="{{ route('produto.edit', ['produto' => $produto]) }}" class="btn-personalizar w-100 d-block text-center text-decoration-none" style="background-color: var(--main_color); font-size: 0.9rem;">
                        Editar Produto
                    </a>
                    {{-- Botão Eliminar (Cards) --}}
                    <form action="{{ url('produto/'.$produto->id) }}" method="post" class="flex-grow-1 form-eliminar-produto">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-personalizar w-100 py-2 btn-eliminar" style="background-color: var(--color-error); font-size: 0.9rem; margin-top: 0;">
                            Eliminar
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @endforeach
</div>

<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>

<script src="{{ asset('frontend/assets/js/sweetalert2.all.min.js') }}"></script>

<script>
function mostrarToastSucesso(mensagem) {
    Swal.fire({
        icon: 'success',
        title: mensagem,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
}

function mostrarToastErro(mensagem) {
    Swal.fire({
        icon: 'error',
        title: 'Erro',
        text: mensagem,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}
</script>

<script>
    $(document).ready(function() {
        const pesquisa = document.getElementById('pesquisa');
        const filtroTipos = document.getElementById('filtroTipos');
        const visivel = document.getElementById('visibilidades');
        const destaques = document.getElementById('destaques');

        function filtrarProdutos() {
            const texto = pesquisa.value.toLowerCase().trim();
            const tipoId = filtroTipos.value;
            const visivelId = visivel.value;
            const destaqueId = destaques.value;
            let encontrouAlgo = false;

            const itens = document.querySelectorAll('.item-produto');

            itens.forEach(item => {
                const titulo = item.querySelector('h3, td:nth-child(2)')?.textContent.toLowerCase() || "";
                const itemTipo = item.getAttribute('data-tipo');

                const selectVisivel = item.querySelector('.formato_agenda');
                const itemVisivel = selectVisivel ? selectVisivel.value : "0";

                const itemdestaque = item.querySelector('.destaque')?.checked ? "1" : "0";

                const matchTexto = titulo.includes(texto);
                const matchTipo = tipoId === "" || itemTipo === tipoId;
                const matchVisivel = visivelId === "" || itemVisivel === visivelId;
                const matchdestaque = destaqueId === "" || itemdestaque === destaqueId;

                if (matchTexto && matchTipo && matchVisivel && matchdestaque) {
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
                if(msgTabela) msgTabela.style.display = 'table-row';
                if(msgCard) msgCard.style.display = 'block';
            }
        }

        pesquisa.addEventListener('input', filtrarProdutos);
        filtroTipos.addEventListener('change', filtrarProdutos);
        visivel.addEventListener('change', filtrarProdutos);
        destaques.addEventListener('change', filtrarProdutos);
    });

    $(document).ready(function() {
        const toggleBtn = $('#toggleViewBtn');
        const tableView = $('#tableView');
        const cardView = $('#cardView');

        tableView.show();
        cardView.hide();
        toggleBtn.html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');

        toggleBtn.on('click', function() {
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

        $(document).on('click', '.btn-eliminar', function(e) {
            e.preventDefault();
            const form = $(this).closest('.form-eliminar-produto');

            Swal.fire({
                title: 'Tem a certeza?',
                text: "Esta ação não pode ser revertida e o produto será removido permanentemente!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    // AJAX para Visibilidade
    $(document).on('change', '.formato_agenda', function() {
        const $select = $(this);
        const produtoId = $select.data('produto-id');
        const novoStatus = $select.val();

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
                    $(`.formato_agenda[data-produto-id="${produtoId}"]`).val(novoStatus);

                    const dot = $(`.formato_agenda[data-produto-id="${produtoId}"]`).closest('.dash-card').find('.status-dot');
                    if(novoStatus == "1") {
                        dot.css({'background-color': '#4ade80', 'box-shadow': '0 0 8px #4ade80'});
                        mostrarToastSucesso('Produto alterado para Visível!');
                    } else {
                        dot.css({'background-color': '#dc3545', 'box-shadow': '0 0 8px #dc3545'});
                        mostrarToastSucesso('Produto ocultado com sucesso!');
                    }
                }
            },
            error: function() {
                $select.css('border-color', 'var(--color-error)');
                mostrarToastErro('Não foi possível alterar a visibilidade do produto.');
            }
        });
    });

    // AJAX para Destaques
    $(document).on('change', '.destaque', function() {
        const $check = $(this);
        const produtoId = $check.data('produto-id');
        const novoStatus = $check.is(':checked') ? 1 : 0;

        $.ajax({
            url: '/produto/' + produtoId + '/destaque',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                destaque: novoStatus
            },
            success: function(response) {
                $(`.destaque[data-produto-id="${produtoId}"]`).each(function() {
                    $(this).prop('checked', novoStatus === 1);
                    const icon = $(this).next('label').find('i');

                    if (novoStatus === 1) {
                        icon.removeClass('bi-star text-secondary').addClass('bi-star-fill text-warning');
                    } else {
                        icon.removeClass('bi-star-fill text-warning').addClass('bi-star text-secondary');
                    }
                });

                if(novoStatus === 1) {
                    mostrarToastSucesso('Adicionado aos destaques!');
                } else {
                    mostrarToastSucesso('Removido dos destaques!');
                }
            },
            error: function() {
                $check.prop('checked', !$check.is(':checked'));
                mostrarToastErro('Não foi possível atualizar o destaque do produto.');
            }
        });
    });
</script>
