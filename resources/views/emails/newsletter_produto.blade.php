<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Novidade Mimoquices</title>
</head>
<body style="font-family: sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <h2 style="font-size: 1.8rem; color: #222; margin-bottom: 5px;">Olá! Temos um novo produto a pensar em ti </h2>
    
    <h3 style="font-size: 1.4rem; color: #007bff; margin-top: 0;">
        Acabámos de adicionar à nossa loja: {{ $produto->titulo }}
    </h3>
    
    {{-- Exibição normal da Imagem via Storage anexada nativamente no e-mail --}}
    @if($produto->nome_cod)
        @php
            // Constrói o caminho físico absoluto correto para o Laravel anexar a imagem
            $caminhoImagem = public_path('storage/' . str_replace('uploads/', '', $produto->nome_cod));
            
            // Se por acaso não estiver dentro da subpasta uploads, tenta o caminho direto
            if (!file_exists($caminhoImagem)) {
                $caminhoImagem = public_path('storage/' . $produto->nome_cod);
            }
        @endphp

        @if(file_exists($caminhoImagem))
            <div style="text-align: center; margin: 20px 0;">
                {{-- O $message->embed() anexa a imagem no e-mail de forma leve e correta --}}
                <img src="{{ $message->embed($caminhoImagem) }}" 
                     alt="{{ $produto->titulo }}" 
                     style="width: 200px; max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border: 1px solid #eee;"
                />
            </div>
        @endif
    @endif
    
    <div style="background-color: #f7f7f7; padding: 15px; border-radius: 8px; margin: 20px 0;">
        <p style="margin: 0;">{{ $produto->descricao }}</p>
    </div>

    @if($produto->pode_personalizar === 'Sim')
        <p style="color: #28a745; font-weight: bold;"> Este produto pode ser totalmente personalizado por ti!</p>
    @endif

    <div style="text-align: center; margin-top: 30px; margin-bottom: 30px;">
        <a href="{{ url('/produto/' . $produto->url_completo) }}" 
           style="background-color: #007bff; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
            Ver Detalhes do Produto →
        </a>
    </div>

    <hr style="border: 0; border-top: 1px solid #eee; margin-top: 40px;">
    <p style="font-size: 0.8rem; color: #999; text-align: center; margin-bottom: 5px;">
        Recebeste este e-mail porque ativaste a opção de receber novidades no teu registo na Mimoquices.
    </p>
    <p style="font-size: 0.8rem; text-align: center; margin-top: 0;">
        <a href="{{ $unsubscribeUrl }}" style="color: #dc3545; text-decoration: underline;">
            Deixar de receber estes e-mails (Cancelar Newsletter)
        </a>
    </p>
</body>
</html>