<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico - Mimoquices</title>
    <link rel="icon" type="image/png" style="border-radius: .5em;" href="{{ asset('frontend/assets/img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/historico.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-mimo-bg">

@include('partial.header')

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
                {{-- Cabeçalho do Grupo de Pedido --}}
                <div class="pedido-info-header d-flex justify-content-between mb-1">
                    <span class="pedido-data">Realizado em {{ $pedido->created_at->format('d/m/Y') }}</span>

                @if($pedido->estado === 'não visto')
                    <form action="{{ route('pedido.destroy', $pedido->id) }}" method="POST" style="display:inline-block; margin-left: 15px;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem a certeza que deseja apagar este pedido?');">
                            Apagar Pedido
                        </button>
                    </form>
                @endif
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
                            @foreach($itens as $item)
                                <tr>
                                    <td data-label="Produto">
                                        <div class="produto-info">
                                            <a href="{{ route('produto.show', $item->produto->url_completo) }}" class="produto-nome-link">
                                                {{ $item->produto?->titulo ?? 'Produto indisponível' }}
                                            </a>
                                        </div>
                                    </td>
                                    
                                    <td data-label="Personalização">
                                        <div class="texto-personalizado">
                                            {{ str_replace('_', ' ', $item->personalizacao_pedida) }}
                                        </div>
                                    </td>


                                    <td data-label="Opções">
                                        <div class="tags-container">
                                            @php 
                                                $opcoes = is_array($item->opcoes_selecionadas) ? $item->opcoes_selecionadas : explode(',', $item->opcoes_selecionadas);
                                            @endphp
                                            
                                            @foreach($opcoes as $opcao)
                                                @if(trim($opcao) != "")
                                                    <span class="tag-mimo">{{ trim($opcao) }}</span>
                                                @endif
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
