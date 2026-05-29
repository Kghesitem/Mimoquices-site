<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personalizações - Mimoquices</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial/header')

<div class="d-flex justify-content-center" style="margin: 1.5rem; 0">
        <a class="btn botao-voltar text-decoration-none d-inline-flex align-items-center" href="{{ route('tabelaPedidos') }}" style="gap: 0.5rem;">
            ← Voltar para a tabela de pedidos
        </a>
    </div>
<main>
    <div class="auth-container" style="max-width:80%">

        {{-- HEADER DA PÁGINA --}}
        <div class="auth-header">
            <h1>Pedido de Produto</h1>
            <p>Aqui podes consultar todos os pedidos personalizados</p>
        </div>

        @forelse($historico->groupBy('id_pedido') as $idPedido => $itens)
            @php
                $pedido = $itens->first()->pedido;
                // Obtemos o produto através do primeiro item do grupo
                $produtoDoPedido = $itens->first()->produto;
            @endphp

            <div class="card" style="margin:20px; padding:20px; border-radius:12px; background:#fff; box-shadow:0 5px 15px rgba(0,0,0,0.05);">

                {{-- INFO CABEÇALHO DO CARD --}}
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:15px; border-bottom: 1px solid #f0f0f0; padding-bottom: 10px;">
                    <div>
                        <h3 style="margin:0; font-size: 1.1rem; color: #333;">
                            Produto: 
                            <a href="{{ route('produto.show', $produtoDoPedido->url_completo) }}" style="color: #007bff; text-decoration: none;">
                                {{ $produtoDoPedido?->titulo ?? 'Produto indisponível' }}
                            </a>
                        </h3>
                        <small style="color: #888;">📅 {{ $pedido?->created_at?->format('d/m/Y') ?? 'Data indisponível' }}</small>
                    </div>

                    <span style="font-weight:600; color:#666; background: #f9f9f9; padding: 5px 12px; border-radius: 8px;">
                        {{ $pedido->estado ?? 'Sem estado' }}
                    </span>
                </div>

                {{-- TABELA --}}
                <div style="overflow-x:auto;">
                    <table style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr style="background:#f5f5f5;">
                                {{-- COLUNA PRODUTO REMOVIDA DAQUI --}}
                                <th style="padding:10px; text-align:left;">Personalização</th>
                                <th style="padding:10px; text-align:left;">Opções Selecionadas</th>
                            </tr>
                        </thead>
                        <tbody>

                        @php
                            $itensAgrupados = $itens->groupBy('personalizacao_pedida');
                        @endphp

                        @foreach($itensAgrupados as $personalizacao_id => $grupoItens)
                            <tr>
                                <td style="padding:10px; border-bottom:1px solid #eee; font-weight: 500;">
                                    @php
                                        $personalizacao = $pesonalizacoes->firstWhere('id', $personalizacao_id);
                                    @endphp
                                    {{ $personalizacao ? $personalizacao->titulo : str_replace('_', ' ', $personalizacao_id) }}
                                </td>

                                <td style="padding:10px; border-bottom:1px solid #eee;">
                                    @php
                                        $todosOpcoes = [];
                                        foreach($grupoItens as $item) {
                                            $opcoes = is_array($item->opcoes_selecionadas) 
                                                ? $item->opcoes_selecionadas 
                                                : explode(',', $item->opcoes_selecionadas);
                                            $todosOpcoes = array_merge($todosOpcoes, $opcoes);
                                        }
                                        $todosOpcoes = array_unique(array_filter($todosOpcoes));
                                    @endphp

                                    @foreach($todosOpcoes as $opcao_id)
                                        @php
                                            $resposta = $selecionadas->firstWhere('id', trim($opcao_id));
                                            $texto = $resposta ? $resposta->resposta : $opcao_id;
                                        @endphp
                                        <span style="background:#eef; padding:5px 10px; border-radius:20px; margin:2px; display:inline-block; font-size: 0.9rem;">
                                            {{ $texto }}
                                        </span>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        @empty
            <div class="auth-footer" style="text-align: center; margin-top: 50px;">
                <p>Ainda não tens personalizações.</p>
                <a href="{{ route('produto.index') }}">Explorar produtos →</a>
            </div>
        @endforelse

    </div>
</main>

@include('partial/footer')
</body>
</html>