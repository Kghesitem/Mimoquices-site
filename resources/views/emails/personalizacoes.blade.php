<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Confirmação da personalização do seu produto</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f4; padding:20px 0;">
    <tr>
        <td align="center">

            <!-- Container principal -->
            <table width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; background-color:#ffffff; border-radius:6px; overflow:hidden;">

                <!-- Cabeçalho -->
                <tr>
                    <td style="padding:24px; text-align:center; border-bottom:1px solid #e5e5e5;">
                        <h1 style="margin:0; font-size:20px; color:#333333; font-weight:600;">
                            Confirmação da personalização do seu produto
                        </h1>
                    </td>
                </tr>

                <!-- Conteúdo -->
                <tr>
                    <td style="padding:24px; color:#333333; font-size:14px; line-height:1.5;">

                        <!-- Nome do produto -->
                        <p style="margin:0 0 16px 0; font-size:16px; font-weight:600;">
                            {{ $produto->titulo }}
                        </p>

                        <!-- Imagem do produto -->
                        <table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" style="padding:16px 0;">
                                    <img
                                        src="{{ $message->embed(public_path('storage/' . $produto->nome_cod)) }}"
                                        width="300"
                                        alt="Imagem do produto"
                                    >
                                    <!-- quando tiver um dominiu utilizar este codigo 
                                    <img src="https://teudominio.pt/storage/uploads/{{ $produto->nome_cod }}">-->

                                </td>
                            </tr>
                        </table>

                        <!-- Personalizações -->
                        <p style="margin:24px 0 12px 0; font-weight:600;">
                            Personalizações seleccionadas:
                        </p>

                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            @foreach ($personalizacoes as $personalizacao)
                                <tr>
                                    <td style="padding:10px; border:1px solid #e5e5e5; background-color:#fafafa; font-weight:600; width:45%;">
                                        {{ $personalizacao->personalizacao_pedida }}
                                    </td>
                                    <td style="padding:10px; border:1px solid #e5e5e5;">
                                        {{ $personalizacao->opcoes_selecionadas }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                        <!-- Mensagem final -->
                        <p style="margin:24px 0 8px 0;">
                            Obrigado pela sua preferência.
                        </p>

                        <p style="margin:0;">
                            O seu pedido foi registado com sucesso e será processado com base nas personalizações seleccionadas.
                        </p>

                    </td>
                </tr>

                <!-- Rodapé -->
                <tr>
                    <td style="padding:16px; text-align:center; font-size:12px; color:#777777; border-top:1px solid #e5e5e5;">
                        Este é um email automático. Por favor, não responda a esta mensagem.
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>
