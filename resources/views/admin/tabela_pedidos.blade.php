@include('partial.header')
<head>
    <title>Lista de Pedidos - Mimoquices</title>
</head>

    <a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ url('/dashboard') }}">
        ← Voltar
    </a>

<div class="dashboard-mimo" style="padding: 2rem;">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; max-width: 1200px; margin: 0 auto 2rem;">
        <h1 style="color: var(--color1); margin: 0;"><x-heroicon-c-shopping-bag style=" width: 3rem; height: 3rem; color:var(--main_color);"/> Gestão de Pedidos</h1>
        <button id="toggleViewBtn" class="tab-button active">
            <i class="bi bi-grid-3x3-gap"></i> Ver em Cards
        </button>
    </div>

<div id="tableView" class="profile-card container-fluid p-0 mb-4" style="display: none; background-color: white; border: 2px solid var(--main_color); overflow: hidden;">
    <div class="table-responsive">
        <table class="table table-hover m-0" style="font-family: inherit;">
            <thead style="background-color: var(--main_color_light);">
                <tr style="border-bottom: 2px solid var(--main_color);">
                    <th class="ps-4 py-3" style="color: var(--color1); font-weight: 700;">Nome de Utilizador</th>
                    <th class="py-3" style="color: var(--color1); font-weight: 700;">Nº do pedido</th>
                    <th class="py-3 text-center" style="color: var(--color1); font-weight: 700;">Andamento do Pedido</th>
                    <th class="py-3 text-center" style="color: var(--color1); font-weight: 700;">Criado em</th>
                    <th class="py-3 text-center" style="color: var(--color1); font-weight: 700;">Ultima Atualização em</th>
                    <th class="pe-4 py-3 text-end" style="color: var(--color1); font-weight: 700;">Ações</th>
                </tr>
            </thead>
            <tbody>
                @if($pedidos->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center py-4" style="color: var(--color-muted); font-style: italic;">Nenhum pedido encontrado.</td>
                    </tr>
                @endif
                @foreach ($pedidos as $pedido)
                <tr class="align-middle" style="border-bottom: 1px solid var(--color-border);">
                    <td class="ps-4 font-weight-700" style="color: var(--color1); font-weight: 700;">
                        @foreach ($users as $user)
                            @if ($pedido->id_user === $user->id) {{ $user->name }} @endif
                        @endforeach 
                    </td>   
                    <td>
                        <span class="badge" style="background-color: var(--main_color_light); color: var(--main_color); border: 1px solid var(--main_color);">
                            {{ $pedido->id }}
                        </span>
                    </td>
                    <td class="text-center">
                        <select class="form-select-personalizacao formato_agenda py-1 px-2" data-pedido-id="{{ $pedido->id }}" style="width: auto; display: inline-block;">
                            <option value="não visto" {{ $pedido->estado == 'não visto' ? 'selected' : '' }}> Não visto</option>
                            <option value="visto" {{ $pedido->estado == 'visto' ? 'selected' : '' }}> Visto</option>
                            <option value="a trabalhar" {{ $pedido->estado == 'a trabalhar' ? 'selected' : '' }}> A Trabalhar</option>
                            <option value="concluido" {{ $pedido->estado == 'concluido' ? 'selected' : '' }}> Concluído</option>
                        </select>
                    </td>
                    <td class="text-center text-muted" style="font-size: 0.95rem;"> {{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td class="text-center text-muted" style="font-size: 0.95rem;">
                        {{ $pedido->updated_at == $pedido->created_at ? 'Sem atualizações' : $pedido->updated_at->format('d/m/Y H:i') }}
                    </td>
                        <td class="d-flex gap-1 justify-content-end" >
                            {{-- Botão Ver --}}
                            <a href="{{ route('pedido.show', $pedido->id) }}">
                                <button class="tab-button text-center" 
                                        style="padding: 6px 12px; font-size: 0.85rem; border-color: var(--main_color); color: var(--main_color); background: transparent; width: 100%; cursor: pointer;">
                                    <x-heroicon-s-eye style="width: 1rem; height: 1rem; color:var(--main_color);"/> Ver
                                </button>
                            </a>
                            {{-- Botão Eliminar --}}
                            <form action="{{ route('pedido.delete', $pedido->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Tem certeza que deseja eliminar este pedido?')"
                                ">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="tab-button" 
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
    @if($pedidos->isEmpty())
        <div class="text-center py-5" style="color: var(--color-muted); font-style: italic; width: 100%;">
            Nenhum pedido encontrado.
        </div>
    @endif
    @foreach ($pedidos as $pedido)
        <div class="dash-card" style="flex: 0 1 280px; min-width: 250px; background-color: white; border: 1px solid var(--color-border); display: flex; flex-direction: column; padding: 1.5rem; border-radius: 1.5rem;">
            
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div style="max-width: 80%;">
                    <h3 style="color: var(--main_color); font-size: 1.1rem; margin: 0; font-family: Georgia, serif;">{{ $pedido->id }}</h3>
                    <small class="text-muted" style="font-family: 'Poppins', sans-serif;">
                        @foreach ($users as $user)
                                @if ($pedido->id_user === $user->id) {{ $user->name }} @endif
                            @endforeach
                    </small>
                </div>
                <span class="status-dot" style="background-color: {{ $pedido->disponivel ? '#4ade80' : '#dc3545' }};"></span>
            </div>

            <div class="form-group-personalizacao mb-3">
                <label class="small fw-bold mb-1" style="display: block;">Estado do Pedido</label>
                <select class="form-select-personalizacao formato_agenda py-1" data-pedido-id="{{ $pedido->id }}">
                    <option value="não visto" {{ $pedido->estado == 'não visto' ? 'selected' : '' }}> Não visto</option>
                    <option value="visto" {{ $pedido->estado == 'visto' ? 'selected' : '' }}> Visto</option>
                    <option value="a trabalhar" {{ $pedido->estado == 'a trabalhar' ? 'selected' : '' }}> A Trabalhar</option>
                    <option value="concluido" {{ $pedido->estado == 'concluido' ? 'selected' : '' }}> Concluído</option>
                </select>
            </div>

            <div class="mt-auto pt-2" style="border-top: 1px dashed var(--color-border);">
                <div style="font-size: 0.75rem; color: #888; margin-bottom: 10px;">
                    <div class="d-flex align-items-center mb-1">
                        <span class="me-1">📅</span> <b>Criação: </b> {{ $pedido->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="me-1">🔄</span> <b>Edição: </b> {{ $pedido->updated_at == $pedido->created_at ? '-' : $pedido->updated_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                <div class="d-flex gap-2 flex-column">
                     <a href="{{ route('pedido.show', $pedido->id) }}" class="btn-personalizar w-100 d-block text-center text-decoration-none" style="background-color: var(--main_color); font-size: 0.9rem;">
                                    Ver Conteúdo
                            </a>
                    {{-- {{ route('pedido.destroy', $pedido->id) }} --}}
                    <form action="{{ route('pedido.delete', $pedido->id) }}" method="post" class="flex-grow-1" onsubmit="return confirm('Eliminar definitivamente?')">
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
    const toggleBtn = $('#toggleViewBtn');
    const tableView = $('#tableView');
    const cardView = $('#cardView');

    tableView.show();
    cardView.hide();
    toggleBtn.html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');

    // Função reutilizável para atualizar cores de um select
    function atualizarStatus($select) {
        const pedidoId = $select.data('pedido-id');
        const novoStatus = $select.val();

        $select.css('border-color', 'var(--main_color)');

        $.ajax({
            url: '/pedido/' + pedidoId + '/atualizar',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                estado: novoStatus
            },
            success: function (response) {
                if (!response.success) {
                    $select.css('border-color', 'var(--color-error)');
                    return;
                }

                // Sincroniza selects com o mesmo pedido
                $('.formato_agenda[data-pedido-id="' + pedidoId + '"]')
                    .not($select)
                    .val(novoStatus);

                const cores = {
                    "não visto": "#dc3545",
                    "visto": "#facc15",
                    "a trabalhar": "#4ade80",
                    "concluido": "#3b82f6"
                };

                const cor = cores[novoStatus] || "#6b7280";

                const card = $select.closest('.dash-card');
                if (card.length) {
                    const dot = card.find('.status-dot');
                    dot.css({
                        'background-color': cor,
                        'box-shadow': `0 0 8px ${cor}`
                    });
                }
            },
            error: function () {
                $select.css('border-color', 'var(--color-error)');
                alert('Erro ao actualizar o estado. Tenta novamente.');
            }
        });
    }

    // Clique no toggle
    toggleBtn.on('click', function() {
        const isShowingTable = tableView.is(':visible');

        if (isShowingTable) {
            // Mudar para cards
            tableView.hide();
            cardView.fadeIn().css('display', 'flex');
            $(this).html('<i class="bi bi-table"></i> Ver em Tabela');

            // Disparar o segundo script automaticamente para todos os selects nos cards
            cardView.find('.formato_agenda').each(function() {
                atualizarStatus($(this));
            });
        } else {
            // Mudar para tabela
            cardView.hide();
            tableView.fadeIn();
            $(this).html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');
        }
    });

    // Quando um select é alterado manualmente
    $(document).on('change', '.formato_agenda', function () {
        atualizarStatus($(this));
    });
});
</script>

@include('partial.footer')
