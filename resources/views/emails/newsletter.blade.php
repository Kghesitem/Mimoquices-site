<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Produtos selecionados - Mimoquices</title>

    {{-- ESTILOS EXCLUSIVOS PARA TELEMÓVEIS --}}
    <style>
        @media only screen and (max-width: 599px) {
            .grelha-produtos {
                width: 100% !important;
                display: block !important;
            }
            .card-produto {
                display: block !important;
                width: 100% !important;
                max-width: 340px !important;
                margin: 15px auto !important;
                float: none !important;
            }
            /* Garante que os elementos de texto puros respeitam o centro */
            .card-produto h3,
            .card-produto p {
                text-align: center !important;
            }
            .botao-link {
                width: 100% !important;
                max-width: 240px !important;
            }
        }
    </style>
</head>
<body style="margin:0; padding:0; background-color:#ffffff; font-family:'Poppins', Arial, sans-serif; color:#333;">

{{-- 1. CONTÊNDOR DO FUNDO GERAL (Substituído por CSS Layout) --}}
<div style="background-color:#ffffff; padding:40px 10px; width:100%; box-sizing:border-box; text-align:center;">

    {{-- 2. CARTÃO PRINCIPAL DA NEWSLETTER (Centralizado via CSS) --}}
    <div style="max-width:600px; margin:0 auto; background-color:#f9f9f9; border-radius:15px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 2px solid #eee; box-sizing:border-box; text-align:left;">

        {{-- CABEÇALHO DO EMAIL --}}
        <div style="padding:40px 30px; text-align:center; background-color:#f9f9f9; border-bottom: 2px solid #f0f0f0;">
            <h1 style="margin:0; font-size:24px; color:#333; font-weight:700; text-align:center;">
                Estivemos a pensar em ti
            </h1>
            <p style="margin:10px 0 0 0; color:#777; font-size:15px; text-align:center;">
                Separámos alguns produtos incríveis da nossa loja. Dê uma vista de olhos!
            </p>
        </div>

        {{-- CORPO PRINCIPAL (LISTAGEM DE PRODUTOS) --}}
        <div style="padding:20px 15px; text-align:center; box-sizing:border-box;">

            @if(!empty($texto))
                <p style="margin:0 auto 20px auto; color:#555; font-size:14px; line-height:1.8; max-width:520px; text-align:center;">
                    {!! nl2br(e($texto)) !!}
                </p>
            @endif

            {{-- Divide a coleção de produtos em grupos de 2 --}}
            @foreach($produtos->chunk(2) as $parProdutos)
                @php
                    $isSoloImpar = $parProdutos->count() == 1;
                @endphp

                {{-- 3. GRELHA DE PRODUTOS (Substituída por bloco inline flexível) --}}
                <div class="grelha-produtos" style="max-width: 560px; margin: 0 auto; text-align: center; font-size: 0;">

                    @foreach($parProdutos as $produto)

                        {{-- 4. CARD DO PRODUTO (Substituído por Div Inline-Block para comportamento responsivo nativo) --}}
                        <div class="card-produto" style="display: inline-block; vertical-align: top; font-size: 14px; width: {{ $isSoloImpar ? '100%' : '47%' }}; max-width: {{ $isSoloImpar ? '340px' : '260px' }}; margin: 10px 1.5%; background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); box-sizing: border-box; text-align: center;">

                            <div style="padding: 20px; text-align: center;">

                                {{-- Título do Produto --}}
                                <h3 style="margin: 0 0 15px 0; color: #333; text-align: center; font-size: 16px; border-bottom: 2px solid #fdf2f2; padding-bottom: 10px; font-weight: 600; min-height: 40px;">
                                    {{ $produto->titulo }}
                                </h3>

                                {{-- Imagem do Produto Centrada --}}
                                @if($produto->nome_cod)
                                    @php
                                        $caminhoImagem = public_path('storage/' . str_replace('uploads/', '', $produto->nome_cod));
                                        if (!file_exists($caminhoImagem)) {
                                            $caminhoImagem = public_path('storage/' . $produto->nome_cod);
                                        }
                                    @endphp

                                    @if(file_exists($caminhoImagem))
                                        {{-- 5. CONTAINER DA IMAGEM (Substituído por Div) --}}
                                        <div style="margin: 0 auto 15px auto; text-align: center;">
                                            <img src="{{ $message->embed($caminhoImagem) }}"
                                                 alt="{{ $produto->titulo }}"
                                                 width="140"
                                                 height="140"
                                                 style="width: 140px; max-width: 140px; height: 140px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; display: inline-block; margin: 0 auto;">
                                        </div>
                                    @endif
                                @endif

                                {{-- Descrição do Produto --}}
                                <p style="margin: 0 0 15px 0; color: #666; font-size: 13px; line-height: 1.5; text-align: center; min-height: 60px;">
                                    {{ Str::limit($produto->descricao, 95, '...') }}
                                </p>

                                {{-- Alerta de Personalização Centrado --}}
                                {{-- 6. CONTAINER DE PERSONALIZAÇÃO (Substituído por Div) --}}
                                <div style="margin: 0 auto 20px auto; min-height: 35px; text-align: center;">
                                    @if($produto->pode_personalizar === 'Sim')
                                        <div style="padding: 6px 10px; background-color: #f6fbf7; border-radius: 8px; border: 1px solid #e6f4ea; text-align: center; display: inline-block; width: 80%; margin: 0 auto; box-sizing: border-box;">
                                            <p style="margin: 0; color: #28a745; font-weight: 600; font-size: 11px; text-align: center;">
                                                Personalizável por ti!
                                            </p>
                                        </div>
                                    @else
                                        <div style="padding: 6px 10px; border: 1px solid transparent;">&nbsp;</div>
                                    @endif
                                </div>

                                {{-- Botão Ver Detalhes Centrado --}}
                                {{-- 7. CONTAINER DO BOTÃO (Substituído por Div) --}}
                                <div style="margin: auto auto 0 auto; text-align: center;">
                                    <a href="{{ url('/produto/' . $produto->url_completo) }}" class="botao-link"
                                       style="background-color: #333333; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; font-size: 13px; width: 80%; text-align: center; margin: 0 auto; box-sizing: border-box;">
                                        Ver Detalhes →
                                    </a>
                                </div>

                            </div>
                        </div>

                    @endforeach

                </div>
            @endforeach

        </div>

        {{-- RODAPÉ DO EMAIL --}}
        <div style="padding: 20px 30px 40px 30px; text-align: center; font-size: 12px; color: #aaa; border-top: 2px solid #f0f0f0; background-color: #fbfbfb; box-sizing: border-box;">
            <p style="margin: 0 0 10px 0; line-height: 1.5; text-align: center;">
                Recebeste este e-mail porque ativaste a opção de receber novidades no teu registo na Mimoquices.
            </p>
            <p style="margin: 0 0 20px 0; text-align: center;">
                <a href="{{ $unsubscribeUrl }}" style="color: #dc3545; text-decoration: underline; font-weight: 600;">
                    Deixar de receber estes e-mails
                </a>
            </p>
            <p style="margin: 0; font-weight: 500; text-align: center;">
                © {{ date('Y') }} Mimoquices. Todos os direitos reservados.
            </p>
        </div>

    </div>
</div>

</body>
</html>
