<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Produtos selecionados - Mimoquices</title>
    
    {{-- ESTILOS EXCLUSIVOS PARA TELEMÓVEIS --}}
    <style>
        @media only screen and (max-width: 599px) {
            .tabela-grelha, .tabela-grelha tbody, .tabela-grelha tr {
                display: block !important;
                width: 100% !important;
            }
            .coluna-produto {
                display: block !important;
                width: 100% !important;
                max-width: 340px !important;
                margin: 0 auto 20px !important;
                padding: 0 !important;
            }
            .card-interno {
                margin: 10px auto !important;
                width: 100% !important;
                max-width: 320px !important;
            }
            /* Garante que os elementos de texto puros respeitam o centro */
            .card-interno h3, 
            .card-interno p {
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

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#ffffff; padding:40px 10px;">
    <tr>
        <td align="center">
            {{-- CARTÃO PRINCIPAL DA NEWSLETTER --}}
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background-color:#f9f9f9; border-radius:15px; overflow:hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 2px solid #eee;">
                
                {{-- CABEÇALHO DO EMAIL --}}
                <tr>
                    <td style="padding:40px 30px; text-align:center; background-color:#f9f9f9; border-bottom: 2px solid #f0f0f0;">
                        <h1 style="margin:0; font-size:24px; color:#333; font-weight:700; text-align:center;">
                            Estivemos a pensar em ti
                        </h1>
                        <p style="margin:10px 0 0 0; color:#777; font-size:15px; text-align:center;">
                            Separámos alguns produtos incríveis da nossa loja. Dê uma vista de olhos!
                        </p>
                    </td>
                </tr>

                {{-- CORPO PRINCIPAL (LISTAGEM DE PRODUTOS) --}}
                <tr>
                    <td style="padding:20px 15px; text-align:center;" align="center">
                        
                        {{-- Divide a coleção de produtos em grupos de 2 --}}
                        @foreach($produtos->chunk(2) as $parProdutos)
                            
                            <table class="tabela-grelha" width="100%" border="0" cellpadding="0" cellspacing="0" style="max-width: 560px; margin: 0 auto;" align="center">
                                <tr>
                                    @foreach($parProdutos as $produto)
                                        @php
                                            $isSoloImpar = $parProdutos->count() == 1;
                                        @endphp
                                        
                                        <td class="coluna-produto" valign="top" align="center" width="{{ $isSoloImpar ? '100%' : '50%' }}" style="padding: 10px; height: 100%;">
                                            
                                            <table class="card-interno" align="center" cellpadding="0" cellspacing="0" width="100%" style="max-width: {{ $isSoloImpar ? '340px' : '260px' }}; background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); height: 100%;">
                                                <tr>
                                                    <td style="padding: 20px; vertical-align: top; text-align: center;" align="center">
                                                        
                                                        {{-- Título do Produto --}}
                                                        <h3 style="margin: 0 0 15px 0; color: #333; text-align: center; font-size: 16px; border-bottom: 2px solid #fdf2f2; padding-bottom: 10px; font-weight: 600; min-height: 40px;">
                                                            {{ $produto->titulo }}
                                                        </h3>

                                                        {{-- Imagem do Produto Centrada com Bloco Rígido --}}
                                                        @if($produto->nome_cod)
                                                            @php
                                                                $caminhoImagem = public_path('storage/' . str_replace('uploads/', '', $produto->nome_cod));
                                                                if (!file_exists($caminhoImagem)) {
                                                                    $caminhoImagem = public_path('storage/' . $produto->nome_cod);
                                                                }
                                                            @endphp

                                                            @if(file_exists($caminhoImagem))
                                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 15px auto;" align="center">
                                                                    <tr>
                                                                        <td align="center" style="text-align: center;">
                                                                            <img src="{{ $message->embed($caminhoImagem) }}" 
                                                                                 alt="{{ $produto->titulo }}" 
                                                                                 width="140"
                                                                                 height="140"
                                                                                 style="width: 140px; max-width: 140px; height: 140px; object-fit: cover; border-radius: 10px; border: 1px solid #eee; display: inline-block; margin: 0 auto;">
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            @endif
                                                        @endif

                                                        {{-- Descrição do Produto --}}
                                                        <p style="margin: 0 0 15px 0; color: #666; font-size: 13px; line-height: 1.5; text-align: center; min-height: 60px;">
                                                            {{ Str::limit($produto->descricao, 95, '...') }}
                                                        </p>

                                                        {{-- Alerta de Personalização Centrado --}}
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto 20px auto;" align="center">
                                                            <tr>
                                                                <td align="center" style="min-height: 35px; text-align: center;">
                                                                    @if($produto->pode_personalizar === 'Sim')
                                                                        <div style="padding: 6px 10px; background-color: #f6fbf7; border-radius: 8px; border: 1px solid #e6f4ea; text-align: center; display: inline-block; width: 80%; margin: 0 auto;">
                                                                            <p style="margin: 0; color: #28a745; font-weight: 600; font-size: 11px; text-align: center;">
                                                                                Personalizável por ti!
                                                                            </p>
                                                                        </div>
                                                                    @else
                                                                        <div style="padding: 6px 10px; border: 1px solid transparent;">&nbsp;</div>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>

                                                        {{-- Botão Ver Detalhes Centrado --}}
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin: auto auto 0 auto;" align="center">
                                                            <tr>
                                                                <td align="center" style="text-align: center;">
                                                                    <a href="{{ url('/produto/' . $produto->url_completo) }}" class="botao-link"
                                                                       style="background-color: #333333; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: 600; display: inline-block; font-size: 13px; width: 80%; text-align: center; margin: 0 auto;">
                                                                        Ver Detalhes →
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    @endforeach
                                    
                                    @if($parProdutos->count() == 1 && !$isSoloImpar)
                                        <td width="50%" style="padding: 10px;">&nbsp;</td>
                                    @endif
                                </tr>
                            </table>

                        @endforeach

                    </td>
                </tr>

                {{-- RODAPÉ DO EMAIL --}}
                <tr>
                    <td style="padding: 20px 30px 40px 30px; text-align: center; font-size: 12px; color: #aaa; border-top: 2px solid #f0f0f0; background-color: #fbfbfb;">
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
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>