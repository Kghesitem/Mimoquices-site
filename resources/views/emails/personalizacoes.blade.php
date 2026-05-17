<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Confirmação da personalização</title>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:'Poppins', Arial, sans-serif; color:#333;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#ffffff; padding:40px 10px;">
    <tr>
        <td align="center">
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background-color:#f9f9f9; border-radius:15px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 2px solid #eee;">
                
                <tr>
                    <td style="padding:40px 30px; text-align:center; background-color:#f9f9f9; border-bottom: 2px solid #f0f0f0;">
                        <h1 style="margin:0; font-size:24px; color:#333; font-weight:700;"><x-heroicon-s-sparkles style="width: 1.25rem; height: 1.25rem; color: var(--main_color);"/> Personalização Registada</h1>
                        <p style="margin:10px 0 0 0; color:#777; font-size:15px;">Confirmamos as tuas escolhas personalizadas com sucesso!</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:30px;">
                        
                        @php
                            $itensAgrupados = $itens->groupBy('id_produto');
                        @endphp

                        @foreach($itensAgrupados as $idProduto => $grupoDePersonalizacoes)
                            @php $produtoDesteGrupo = $grupoDePersonalizacoes->first()->produto; @endphp

                            <div style="margin-bottom: 30px; padding: 20px; border-radius: 12px; background-color: #fff; border: 1px solid #f0f0f0;">
                                
                                @if($produtoDesteGrupo && $produtoDesteGrupo->nome_cod)
                                    <div style="text-align: center; margin-bottom: 15px;">
                                        <img src="{{ $message->embed(public_path('storage/' . $produtoDesteGrupo->nome_cod)) }}" 
                                             alt="Produto" 
                                             style="width: 120px; border-radius: 10px; border: 1px solid #eee;">
                                    </div>
                                @endif

                                <h3 style="margin: 0 0 15px 0; color: #333; text-align: center; font-size: 18px; border-bottom: 2px solid #fdf2f2; padding-bottom: 10px;">
                                    {{ $produtoDesteGrupo?->titulo ?? 'Produto' }}
                                </h3>

                                <table width="100%" cellpadding="0" cellspacing="0">
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
                                        <tr>
                                            <td style="padding: 12px 0; border-bottom: 1px solid #f9f9f9; width: 45%; color: #888; font-size: 14px; text-transform: uppercase; font-weight: 600;">
                                                {{ $tituloPerso }}
                                            </td>
                                            <td style="padding: 12px 0; border-bottom: 1px solid #f9f9f9; font-weight: 500; color: #333; font-size: 15px; text-align: right;">
                                                {{ implode(', ', $textosOpcoes) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        @endforeach

                        <div style="margin-top: 20px; padding: 25px; background-color: #fdfdff; border-radius: 10px; text-align: center; border: 1px dashed #d1d1f0;">
                            <p style="margin: 0 0 10px 0; font-weight: 600; color: #333;">Obrigado pela tua preferência! ❤️</p>
                            <p style="margin: 0; font-size: 13px; color: #777; line-height: 1.6;">
                                O teu pedido foi registado e será processado com base nestas personalizações. Podes consultar o teu histórico a qualquer momento no nosso site.
                            </p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding: 20px; text-align: center; font-size: 12px; color: #aaa;">
                        © {{ date('Y') }} Mimoquices. Todos os direitos reservados.<br>
                        Este é um e-mail automático, por favor não respondas.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>