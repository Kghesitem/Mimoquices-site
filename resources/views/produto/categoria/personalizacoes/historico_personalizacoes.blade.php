@include('partial.header')
<head>
    <title>Histórico - Mimoquices</title>
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/historico.css') }}">
</head>

<main class="historico-container">
    <div class="content-wrapper">
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                {{ session('error') }}
            </div>
        @endif
        
        <header class="historico-header">
            <h1>O Meu Histórico de Mimos</h1>
            <p>Recorda aqui todas as tuas escolhas personalizadas.</p>
        </header>

        @forelse($historico->groupBy('id_pedido') as $idPedido => $itens)
            @php
                $pedido = $itens->first()->pedido;
            @endphp

            <div class="pedido-group mb-3">
                <div class="pedido-group mb-4 p-3 border rounded shadow-sm bg-white">
        {{-- Cabeçalho do Grupo de Pedido --}}
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        
        <div class="d-flex align-items-center">
            <div class="icon-box me-3 bg-white p-2 rounded-circle shadow-sm"style="border:solid 0.5px lightgray">
                <i class="bi bi-calendar-event text-primary"></i> 
            </div>
            <div>
                <small class="text-muted d-block">Data do Pedido</small>
                <strong class="text-dark">{{ $pedido->created_at->format('d/m/Y') }}</strong>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            {{-- Badge de Status Dinâmico --}}
            <span class="badge rounded-pill 
                {{ $pedido->estado === 'não visto' ? 'bg-warning text-dark' : 'bg-success' }}">
                <i class="bi {{ $pedido->estado === 'não visto' ? 'bi-clock' : 'bi-check-circle' }} me-1"></i>
                {{ ucfirst($pedido->estado) }}
            </span>

            {{-- Botão de Apagar (Apenas se não visto) --}}
            @if($pedido->estado === 'não visto')
                <form action="{{ route('pedido.destroy', $pedido->id) }}" method="POST" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm border-0" 
                            onclick="return confirm('Tem a certeza que deseja apagar este pedido?');"
                            title="Apagar Pedido">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>

                <div class="table-container">
                    <table class="mimo-table">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Personalização (Texto)</th>
                                <th>Opções Selecionadas</th>
                            </tr>
                        </thead>
                        <tbody>
    @php
        // Agrupa os itens por personalizacao_pedida
        $itensAgrupados = $itens->groupBy('personalizacao_pedida');
    @endphp

    @foreach($itensAgrupados as $personalizacao_id => $grupoItens)
        <tr>
            {{-- Produto: podemos mostrar o primeiro item --}}
            <td data-label="Produto">
                <div class="produto-info">
                    <a href="{{ route('produto.show', $grupoItens->first()->produto->url_completo) }}" class="produto-nome-link">
                        {{ $grupoItens->first()->produto?->titulo ?? 'Produto indisponível' }}
                    </a>
                </div>
            </td>

            {{-- Personalização --}}
            <td data-label="Personalização">
                <div class="texto-personalizado">
                    @php
                        $personalizacao = $pesonalizacoes->firstWhere('id', $personalizacao_id);
                    @endphp
                    {{ $personalizacao ? $personalizacao->titulo : str_replace('_', ' ', $personalizacao_id) }}
                </div>
            </td>

            {{-- Opções Selecionadas combinadas --}}
            <td data-label="Opções">
                <div class="tags-container">
                    @php
                        $todosOpcoes = [];
                        foreach($grupoItens as $item) {
                            $opcoes = is_array($item->opcoes_selecionadas) 
                                        ? $item->opcoes_selecionadas 
                                        : explode(',', $item->opcoes_selecionadas);
                            $todosOpcoes = array_merge($todosOpcoes, $opcoes);
                        }
                        $todosOpcoes = array_filter($todosOpcoes, fn($o) => trim($o) !== '');
                        $todosOpcoes = array_unique($todosOpcoes);
                    @endphp

                    @foreach($todosOpcoes as $opcao_id)
                        @php
                            $resposta = $selecionadas->firstWhere('id', trim($opcao_id));
                            $texto = $resposta ? $resposta->resposta : $opcao_id;
                        @endphp
                        <span class="tag-mimo">{{ $texto }}</span>
                    @endforeach
                </div>
            </td>
        </tr>
    @endforeach
</tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="empty-container">
                <p class="empty-state">Ainda não tens personalizações gravadas. ✨</p>
                <a href="{{ route('produto.index') }}" class="btn-voltar">Explorar Produtos</a>
            </div>
        @endforelse
    </div>
</main>

@include('partial.footer')

</body>
</html>
