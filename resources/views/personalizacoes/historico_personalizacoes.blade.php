<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/historico.css') }}">
    <title>Histórico - Mimoquices</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend/assets/img/logo.png') }}">
</head>
<body>

@include('partial/header')

<main>
<div class="historico-full-container">
    
    <div class="auth-header rounded" style="text-align: center; margin-bottom: 2rem;">
        <h1>O Meu Histórico de Mimos</h1>
        <p>Recorda aqui todas as tuas escolhas personalizadas</p>
    </div>

    <div class="pedidos-grid">
        @forelse($historico->groupBy('id_pedido') as $idPedido => $itens)
            @php $pedido = $itens->first()->pedido; @endphp

            <div class="pedido-card">
                <div class="pedido-info-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px dashed #f0f0f0; padding-bottom: 10px; margin-bottom: 15px;">
                    <div style="font-weight: 600; color: #555; display: flex; align-items: center; gap: 5px;">
                        <x-heroicon-s-calendar-date-range style="width: 1.5rem; height: 1.5rem; color:var(--main_color); "/> 
                        {{ $pedido->created_at->format('d/m/Y') }} 
                        <span style="font-weight: 400; font-size: 0.8rem; background: #f0f0f0; padding: 4px 10px; border-radius: 20px;">
                            {{ ucfirst($pedido->estado) }}
                        </span>
                    </div>

                    @if($pedido->estado === 'não visto')
                        <form action="{{ route('pedido.destroy', $pedido->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" style="background: none; border: none; color: #ff4d4d; cursor: pointer; display: flex; align-items: center; gap: 3px; font-size: 0.85rem;">
                                <x-heroicon-c-trash style="width: 1.1rem; height: 1.1rem; color:red"/> Apagar
                            </button>
                        </form>
                    @endif
                </div>

                <div class="table-responsive" style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; color: #888; font-size: 0.75rem; text-transform: uppercase;">
                                <th style="padding: 8px;">Produto</th>
                                <th style="padding: 8px;">Personalização</th>
                                <th style="padding: 8px;">Opções</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $itensAgrupados = $itens->groupBy('personalizacao_pedida'); @endphp
                            @foreach($itensAgrupados as $personalizacao_id => $grupoItens)
                                <tr style="border-bottom: 1px solid #fafafa; font-size: 0.9rem;">
                                    <td style="padding: 10px;">
                                        <a href="{{ route('produto.show', $grupoItens->first()->produto->url_completo) }}" style="color: #ff99aa; text-decoration: none; font-weight: 500;">
                                            {{ $grupoItens->first()->produto?->titulo ?? 'Indisponível' }}
                                        </a>
                                    </td>
                                    <td style="padding: 10px; color: #666;">
                                        @php $pInfo = $pesonalizacoes->firstWhere('id', $personalizacao_id); @endphp
                                        {{ $pInfo ? $pInfo->titulo : str_replace('_', ' ', $personalizacao_id) }}
                                    </td>
                                    <td style="padding: 10px;">
                                        <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                            @php
                                                $todosOpcoes = [];
                                                foreach($grupoItens as $item) {
                                                    $opcoes = is_array($item->opcoes_selecionadas) ? $item->opcoes_selecionadas : explode(',', $item->opcoes_selecionadas);
                                                    $todosOpcoes = array_merge($todosOpcoes, $opcoes);
                                                }
                                                $todosOpcoes = array_unique(array_filter($todosOpcoes, fn($o) => trim($o) !== ''));
                                            @endphp
                                            @foreach($todosOpcoes as $opcao_id)
                                                @php
                                                    $resposta = $selecionadas->firstWhere('id', trim($opcao_id));
                                                    $texto = $resposta ? $resposta->resposta : $opcao_id;
                                                @endphp
                                                <span style="background: #fff5f7; color: #ff8899; padding: 1px 8px; border-radius: 10px; font-size: 0.75rem; border: 1px solid #ffeef0; white-space: nowrap;">
                                                    {{ $texto }}
                                                </span>
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
            <div style="grid-column: span 2; text-align: center; padding: 5rem 0;">
                <p>Ainda não tens personalizações gravadas.</p>
                <a href="{{ route('produto.index') }}" class="btn-submit" style="display: inline-block; text-decoration: none; margin-top: 20px; width: auto; padding: 10px 40px; background-color: var(--main_color); color: white; border-radius: 8px;">
                    Explorar Produtos
                </a>
            </div>
        @endforelse
    </div>
</div>
</main>

@include('partial/footer')

<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Feito!', text: "{{ session('success') }}", timer: 2500, showConfirmButton: false });
    @endif

    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Erro', text: "{{ session('error') }}" });
    @endif

    function confirmDelete(button) {
        Swal.fire({
            title: 'Tens a certeza?',
            text: "Este pedido será removido do teu histórico.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4d4d',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Sim, apagar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>

</body>
</html>