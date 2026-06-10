@include('partial.header')
<head>
    <title>Lista de Pedidos - Mimoquices</title>
</head>

<a class="btn botao-voltar mt-4 text-decoration-none d-flex justify-content-center" href="{{ route('dashboard') }}">
    ← Voltar
</a>

{{-- CONTENTOR DOS DOIS GRÁFICOS (Lado a lado com Flexbox responsivo) --}}
<div style="max-width: 1200px; margin: 2rem auto; display: flex; flex-wrap: wrap; gap: 2rem; width: 100%;">

    {{-- 1. Card do Gráfico de Estados dos Pedidos --}}
    <div class="mimo-chart-card wide" style="margin: 0; flex: 1; min-width: 300px;">
        <div class="mimo-chart-header">
            <h2>
                <x-heroicon-c-heart style="color: var(--main_color); width: 1.5rem; height: 1.5rem;"/>
                Estados dos Pedidos
            </h2>
            <p>Distribuição do andamento dos pedidos em tempo real</p>
            <p>Clique no gráfico para filtrar por estado</p>
            <small id="filtroAtivoAviso" class="text-primary fw-bold" style="display:none; cursor:pointer; margin-top:5px;">
                <i class="bi bi-x-circle-fill"></i> Filtro ativo. Clique no gráfico ou aqui para limpar.
            </small>
        </div>
        <div class="mimo-chart-body" style="padding: 1rem 1.5rem 1.5rem;">
            <div class="mimo-chart-wrapper" style="width: 100%; height: 250px; margin: auto; cursor: pointer; position: relative;">
                <canvas id="chartFavoritos"></canvas>
            </div>
        </div>
    </div>

    {{-- 2. Card do Gráfico de Total de Pedidos --}}
    <div class="mimo-chart-card wide" style="margin: 0; flex: 1; min-width: 300px;">
        <div class="mimo-chart-header">
            <h2>
                <x-heroicon-s-shopping-bag style="color: var(--main_color); width: 1.5rem; height: 1.5rem;"/>
                Total de Pedidos
            </h2>
            <p>Volume de encomendas realizadas por produto</p>
        </div>
        <div class="mimo-chart-body" style="padding: 1rem 1.5rem 1.5rem;">
            <div class="mimo-chart-wrapper" style="width: 100%; height: 250px; margin: auto; position: relative;">
                <canvas id="chartPedidos"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="dashboard-mimo" style="padding: 2rem;">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; max-width: 1200px; margin: 0 auto 2rem;">
        <h1 style="color: var(--color1); margin: 0;"><x-heroicon-c-shopping-bag style=" width: 3rem; height: 3rem; color:var(--main_color);"/> Gestão de Pedidos</h1>
        <button id="toggleViewBtn" class="tab-button active">
            <i class="bi bi-grid-3x3-gap"></i> Ver em Cards
        </button>
    </div>

    {{-- Tabela de Pedidos --}}
    <div id="tableView" class="profile-card container-fluid p-0 mb-4" style="display: none; background-color: white; border: 2px solid var(--main_color); overflow: hidden; max-width: 1200px; margin: 0 auto;">
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
                        <tr class="sem-pedidos-tr">
                            <td colspan="6" class="text-center py-4" style="color: var(--color-muted); font-style: italic;">Nenhum pedido encontrado.</td>
                        </tr>
                    @endif
                    @foreach ($pedidos as $pedido)
                    <tr class="align-middle pedido-item-row" style="border-bottom: 1px solid var(--color-border);">
                        <td class="ps-4" style="color: var(--color1); font-weight: 700;">
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
                            <select class="form-select-personalizacao formato_agenda status-select py-1 px-2" data-pedido-id="{{ $pedido->id }}" style="width: auto; display: inline-block;">
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
                            <a href="{{ route('pedido.show', $pedido->id) }}">
                                <button class="tab-button text-center" style="padding: 6px 12px; font-size: 0.85rem; border-color: var(--main_color); color: var(--main_color); background: transparent; width: 100%; cursor: pointer;">
                                    <x-heroicon-s-eye style="width: 1rem; height: 1rem; color:var(--main_color);"/> Ver
                                </button>
                            </a>
                            <form action="{{ route('pedido.delete', $pedido->id) }}" method="POST" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="tab-button btn-eliminar" style="padding: 6px 12px; font-size: 0.85rem; border-color: var(--color-error); color: var(--color-error); background: transparent; width: 100%; cursor: pointer;">
                                    <x-heroicon-c-trash style="width: 1rem; height: 1rem; color:red"/> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr id="noMatchesTable" style="display:none;">
                        <td colspan="6" class="text-center py-4" style="color: var(--color-muted); font-style: italic;">Nenhum pedido corresponde ao filtro selecionado.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Cards de Pedidos --}}
    <div id="cardView" class="container-fluid px-0" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; max-width: 1200px; margin: 0 auto;">
        @if($pedidos->isEmpty())
            <div class="text-center py-5 sem-pedidos-card" style="color: var(--color-muted); font-style: italic; width: 100%;">
                Nenhum pedido encontrado.
            </div>
        @endif
        @foreach ($pedidos as $pedido)
            <div class="dash-card pedido-item-card" style="flex: 0 1 280px; min-width: 250px; background-color: white; border: 1px solid var(--color-border); display: flex; flex-direction: column; padding: 1.5rem; border-radius: 1.5rem;">

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
                    <label class="small fw-bold mb-1" for="status-pedido-{{ $pedido->id }}" style="display: block;">Estado do Pedido</label>

                    <select id="status-pedido-{{ $pedido->id }}" class="form-select-personalizacao formato_agenda status-select py-1" data-pedido-id="{{ $pedido->id }}">
                        <option value="não visto" {{ $pedido->estado == 'não visto' ? 'selected' : '' }}> Não visto</option>
                        <option value="visto" {{ $pedido->estado == 'visto' ? 'selected' : '' }}> Visto</option>
                        <option value="a trabalhar" {{ $pedido->estado == 'a trabalhar' ? 'selected' : '' }}> A Trabalhar</option>
                        <option value="concluido" {{ $pedido->estado == 'concluido' ? 'selected' : '' }}> Concluído</option>
                    </select>
                </div>
                <div class="mt-auto pt-2" style="border-top: 1px dashed var(--color-border);">
                    <div style="font-size: 0.75rem; color: #888; margin-bottom: 10px;">
                        <div class="d-flex align-items-center mb-1">
                            <x-heroicon-o-calendar style="width: 0.95rem; height: 0.95rem; margin-right: 0.25rem; color: #666;" />
                            <b>Criação: </b> &nbsp;{{ $pedido->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="d-flex align-items-center">
                            <x-heroicon-o-arrow-path style="width: 0.95rem; height: 0.95rem; margin-right: 0.25rem; color: #666;" />
                            <b>Edição: </b> &nbsp;{{ $pedido->updated_at == $pedido->created_at ? '-' : $pedido->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                    <div class="d-flex gap-2 flex-column">
                         <a href="{{ route('pedido.show', $pedido->id) }}" class="btn-personalizar w-100 d-block text-center text-decoration-none" style="background-color: var(--main_color); font-size: 0.9rem;">
                                Ver Conteúdo
                         </a>
                        <form action="{{ route('pedido.delete', $pedido->id) }}" method="post" class="flex-grow-1 form-eliminar">
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
        <div id="noMatchesCards" class="text-center py-5" style="display:none; color: var(--color-muted); font-style: italic; width: 100%;">
            Nenhum pedido corresponde ao filtro selecionado.
        </div>
    </div>
</div>

{{-- SCRIPTS JS --}}

<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>

<script src="{{ asset('frontend/assets/js/chart.min.js') }}"></script>

<script src="{{ asset('frontend/assets/js/chartjs-plugin-datalabels.min.js') }}"></script>

<script src="{{ asset('frontend/assets/js/sweetalert2.all.min.js') }}"></script>
<script>
$(document).ready(function() {
    const toggleBtn = $('#toggleViewBtn');
    const tableView = $('#tableView');
    const cardView = $('#cardView');

    tableView.show();
    cardView.hide();
    toggleBtn.html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');
    updateStatusDots();

    $(document).on('click', '.btn-eliminar', function(e) {
        e.preventDefault();
        const form = $(this).closest('.form-eliminar');

        Swal.fire({
            title: 'Tem a certeza?',
            text: "Esta ação não pode ser revertida e o pedido será apagado permanentemente!",
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

                $('.formato_agenda[data-pedido-id="' + pedidoId + '"]').not($select).val(novoStatus);

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

                Swal.fire({
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    title: 'Estado atualizado!',
                    text: 'O estado do pedido foi atualizado para "' + novoStatus + '".',
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function () {
                $select.css('border-color', 'var(--color-error)');
                Swal.fire({
                    icon: 'error',
                    title: 'Erro',
                    text: 'Ocorreu um erro ao atualizar o estado do pedido. Por favor, tente novamente.',
                });
            }
        });
    }

    function updateStatusDots() {
        const cores = {
            "não visto": "#dc3545",
            "visto": "#facc15",
            "a trabalhar": "#4ade80",
            "concluido": "#3b82f6"
        };

        $('.pedido-item-card').each(function() {
            const select = $(this).find('.status-select');
            const status = (select.val() || '').toLowerCase().trim();
            const cor = cores[status] || "#6b7280";
            const dot = $(this).find('.status-dot');
            dot.css({
                'background-color': cor,
                'box-shadow': `0 0 8px ${cor}`
            });
        });
    }

    // Botão de alternar entre Tabela e Cards
    toggleBtn.on('click', function() {
        const isShowingTable = tableView.is(':visible');

        if (isShowingTable) {
            tableView.hide();
            cardView.fadeIn().css('display', 'flex');
            updateStatusDots();
            $(this).html('<i class="bi bi-table"></i> Ver em Tabela');
        } else {
            cardView.hide();
            tableView.fadeIn();
            $(this).html('<i class="bi bi-grid-3x3-gap"></i> Ver em Cards');
        }
    });

    $(document).on('change', '.formato_agenda', function () {
        atualizarStatus($(this));
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let filtroAtual = null;

    const mapaDeCores = {
        'não visto': '#dc3545',
        'visto': '#facc15',
        'a trabalhar': '#4ade80',
        'concluido': '#3b82f6'
    };

    const labelsEstados = @json($labels ?? []);
    const valoresEstados = @json($valores ?? []);
    const totalPedidos = valoresEstados.reduce((a, b) => a + b, 0);
    const coresGrafico = labelsEstados.map(label => mapaDeCores[label.toLowerCase()] || '#6b7280');

    function aplicarFiltro(status) {
        filtroAtual = status;

        if(status) {
            const statusNormalizado = status.toLowerCase().trim();
            $('#filtroAtivoAviso').text('Filtro ativo: ' + status + ' (Clique aqui para limpar)').fadeIn();

            // 1. Filtrar Tabela
            let visiveisNaTabela = 0;
            $('.pedido-item-row').each(function() {
                const statusLinha = $(this).find('.status-select').val().toLowerCase().trim();
                if(statusLinha === statusNormalizado) {
                    $(this).show();
                    visiveisNaTabela++;
                } else {
                    $(this).hide();
                }
            });
            if(visiveisNaTabela === 0 && $('.pedido-item-row').length > 0) {
                $('#noMatchesTable').show();
            } else {
                $('#noMatchesTable').hide();
            }

            // 2. Filtrar Cards
            let visiveisNosCards = 0;
            $('.pedido-item-card').each(function() {
                const statusCard = $(this).find('.status-select').val().toLowerCase().trim();
                if(statusCard === statusNormalizado) {
                    $(this).show();
                    visiveisNosCards++;
                } else {
                    $(this).hide();
                }
            });
            if(visiveisNosCards === 0 && $('.pedido-item-card').length > 0) {
                $('#noMatchesCards').show();
            } else {
                $('#noMatchesCards').hide();
            }

        } else {
            $('#filtroAtivoAviso').fadeOut();
            $('.pedido-item-row').show();
            $('.pedido-item-card').show();
            $('#noMatchesTable').hide();
            $('#noMatchesCards').hide();
        }
    }

    $('#filtroAtivoAviso').on('click', function() {
        aplicarFiltro(null);
    });

    // --- GRÁFICO DE ESTADOS ---
    const ctxFav = document.getElementById('chartFavoritos').getContext('2d');
    new Chart(ctxFav, {
        type: 'bar',
        data: {
            labels: labelsEstados,
            datasets: [{
                label: 'Total de Pedidos',
                data: valoresEstados,
                backgroundColor: coresGrafico,
                hoverOffset: 10
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#000000',
                    anchor: 'end',
                    align: 'right',
                    offset: 4,
                    font: {
                        weight: 'bold',
                        size: 11
                    },
                    formatter: function(value) {
                        if (totalPedidos > 0 && value > 0) {
                            let percentagem = ((value / totalPedidos) * 100).toFixed(1);
                            return `${value} (${percentagem}%)`;
                        }
                        return value;
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 },
                    grace: '8%'
                }
            },
            onClick: (evt, activeElements) => {
                if (activeElements.length > 0) {
                    const firstPoint = activeElements[0];
                    const labelClicada = labelsEstados[firstPoint.index];

                    if (filtroAtual === labelClicada) {
                        aplicarFiltro(null);
                    } else {
                        aplicarFiltro(labelClicada);
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    // --- GRÁFICO DE TOTAL DE PEDIDOS (CORRIGIDO) ---
    const labelsPedidos = @json($labelsPedidos ?? []);
    const valoresPedidos = @json($valoresPedidos ?? []);

    // Se não existirem dados vindos do controlador, colocamos dados de teste temporários para ver se renderiza
    const finalLabels = labelsPedidos.length > 0 ? labelsPedidos : ["Sem Dados"];
    const finalValores = valoresPedidos.length > 0 ? valoresPedidos : [0];

    const ctxPed = document.getElementById('chartPedidos').getContext('2d');
    new Chart(ctxPed, {
        type: 'bar',
        data: {
            labels: finalLabels,
            datasets: [{
                label: 'Vezes Pedido',
                data: finalValores,
                backgroundColor: '#3b82f6', // Cor fixa temporária para garantir que funciona
                borderColor: '#ffffff',
                borderWidth: 1,
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyColor: "#858796",
                    titleColor: '#6e707e',
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    displayColors: true
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { autoSkip: false } },
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
});
</script>

@include('partial.footer')
