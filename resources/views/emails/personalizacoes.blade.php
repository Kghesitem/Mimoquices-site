<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Confirmação da personalização - Mimoquices</title>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:'Poppins', Arial, sans-serif; color:#333;">

{{-- 1. CONTÊNDOR DO FUNDO GERAL (Substituído por CSS Layout) --}}
<div style="background-color:#ffffff; padding:40px 10px; width:100%; box-sizing:border-box; text-align:center;">

    {{-- 2. CARTÃO PRINCIPAL DO EMAIL (Centralizado via CSS) --}}
    <div style="max-width:600px; margin:0 auto; background-color:#f9f9f9; border-radius:15px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 2px solid #eee; box-sizing:border-box; text-align:left;">

        {{-- CABEÇALHO DO EMAIL --}}
        <div style="padding:40px 30px; text-align:center; background-color:#f9f9f9; border-bottom: 2px solid #f0f0f0; box-sizing:border-box;">
            <h1 style="margin:0; font-size:24px; color:#333; font-weight:700; text-align:center;">
                Personalização Confirmada!
            </h1>
            <p style="margin:10px 0 0 0; color:#777; font-size:15px; text-align:center;">
                Confirmamos as tuas escolhas personalizadas com sucesso!
            </p>
        </div>

        {{-- CONTEÚDO PRINCIPAL --}}
        <div style="padding:30px; box-sizing:border-box;">

            @php
                $itensAgrupados = $itens->groupBy('id_produto');
            @endphp

            @foreach($itensAgrupados as $idProduto => $grupoDePersonalizacoes)
                @php
                    $produtoDesteGrupo = $grupoDePersonalizacoes->first()->produto;
                @endphp

                <div style="margin-bottom: 30px; padding: 20px; border-radius: 12px; background-color: #fff; border: 1px solid #f0f0f0; box-sizing:border-box;">

                    @if($produtoDesteGrupo && $produtoDesteGrupo->nome_cod)
                        <div style="text-align: center; margin-bottom: 15px;">
                            <img src="{{ $message->embed(public_path('storage/' . $produtoDesteGrupo->nome_cod)) }}"
                                 alt="Produto: {{ $produtoDesteGrupo->titulo ?? 'Mimoquices' }}"
                                 style="width: 120px; border-radius: 10px; border: 1px solid #eee; display: inline-block;">
                        </div>
                    @endif

                    <h3 style="margin: 0 0 15px 0; color: #333; text-align: center; font-size: 18px; border-bottom: 2px solid #fdf2f2; padding-bottom: 10px; font-weight: 600;">
                        {{ $produtoDesteGrupo?->titulo ?? 'Produto' }}
                    </h3>

                    {{-- 3. GRELHA DE OPÇÕES DO PRODUTO (Substituída por Layout CSS Flutuante) --}}
                    <div style="width: 100%; box-sizing: border-box;">
                        @foreach($grupoDePersonalizacoes->groupBy('personalizacao_pedida') as $idPerso => $opcoesDesteItem)
                            @php
                                $pRef = $pesonalizacoes->firstWhere('id', $idPerso);
                                $tituloPerso = $pRef ? $pRef->titulo : str_replace('_', ' ', $idPerso);

                                $textosOpcoes = [];
                                foreach($opcoesDesteItem as $item) {
                                    $resp = $selecionadas->firstWhere('id', trim($item->opcoes_selecionadas));
                                    $textosOpcoes[] = $resp ? $resp->resposta : $item->opcoes_selecionadas;
                                }
                            @endphp

                            {{-- Linha de Opção --}}
                            <div style="padding: 12px 0; border-bottom: 1px solid #f9f9f9; display: block; overflow: hidden; clear: both;">
                                {{-- Título da customização (Esquerda) --}}
                                <div style="float: left; width: 45%; color: #888; font-size: 14px; text-transform: uppercase; font-weight: 600; text-align: left; word-wrap: break-word;">
                                    {{ $tituloPerso }}
                                </div>
                                {{-- Resposta selecionada (Direita) --}}
                                <div style="float: right; width: 50%; font-weight: 500; color: #333; font-size: 15px; text-align: right; word-wrap: break-word;">
                                    {{ implode(', ', $textosOpcoes) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            {{-- CAIXA DE AGRADECIMENTO --}}
            <div style="margin-top: 20px; padding: 25px; background-color: #fdfdff; border-radius: 10px; text-align: center; border: 1px dashed #d1d1f0; box-sizing:border-box;">
                <p style="margin: 0 0 10px 0; font-weight: 600; color: #333; text-align: center;">
                    Obrigado pela tua preferência!
                </p>
                <p style="margin: 0; font-size: 13px; color: #777; line-height: 1.6; text-align: center;">
                    O teu pedido foi registado e será processado com base nestas personalizações. Podes consultar o teu histórico a qualquer momento no nosso site.
                </p>
            </div>
        </div>

        {{-- RODAPÉ --}}
        <div style="padding: 20px; text-align: center; font-size: 12px; color: #aaa; box-sizing:border-box;">
            <p style="margin: 0 0 5px 0; text-align: center;">
                © {{ date('Y') }} Mimoquices. Todos os direitos reservados.
            </p>
            <p style="margin: 0; text-align: center;">
                Este é um e-mail automático, por favor não respondas.
            </p>
        </div>
    </div>
</div>

</body>
</html>
