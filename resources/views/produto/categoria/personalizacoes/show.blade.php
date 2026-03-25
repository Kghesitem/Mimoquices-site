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
<a class="btn btn-outline-primary mt-4 text-decoration-none d-flex justify-content-center" href="{{ route('tabelaPedidos') }}" style="width: 150px; margin: 0 auto;">
    ← Voltar
</a>
<main>
    
<div class="auth-container" style="max-width:80%">


    <!-- HEADER -->
    <div class="auth-header">
        <h1>✨ As tuas Personalizações</h1>
        <p>Aqui podes consultar todos os teus pedidos personalizados</p>
    </div>



    @forelse($historico->groupBy('id_pedido') as $idPedido => $itens)
        @php
            $pedido = $itens->first()->pedido;
        @endphp

        <div class="card" style="margin:20px; padding:20px; border-radius:12px; background:#fff; box-shadow:0 5px 15px rgba(0,0,0,0.05);">

            <!-- INFO PEDIDO -->
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                <span>
                    📅 {{ $pedido?->created_at?->format('d/m/Y') ?? 'Data indisponível' }}
                </span>

                <span style="font-weight:600; color:#666;">
                    {{ $pedido->estado ?? 'Sem estado' }}
                </span>
            </div>

            <!-- TABELA -->
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f5f5f5;">
                            <th style="padding:10px; text-align:left;">Produto</th>
                            <th style="padding:10px; text-align:left;">Personalização</th>
                            <th style="padding:10px; text-align:left;">Opções</th>
                        </tr>
                    </thead>
                    <tbody>

                    @php
                        $itensAgrupados = $itens->groupBy('personalizacao_pedida');
                    @endphp

                    @foreach($itensAgrupados as $personalizacao_id => $grupoItens)
                        <tr>
                            <td style="padding:10px; border-bottom:1px solid #eee;">
                                <a href="{{ route('produto.show', $grupoItens->first()->produto->url_completo) }}">
                                    {{ $grupoItens->first()->produto?->titulo ?? 'Produto indisponível' }}
                                </a>
                            </td>

                            <td style="padding:10px; border-bottom:1px solid #eee;">
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
                                    <span style="background:#eef; padding:5px 10px; border-radius:20px; margin:2px; display:inline-block;">
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
        <div class="auth-footer">
            <p>Ainda não tens personalizações.</p>
            <a href="{{ route('produto.index') }}">Explorar produtos →</a>
        </div>
    @endforelse

</div>
</main>
@include('partial/footer')