@component('mail::message')
{{-- Cabeçalho com Emoji igual ao teu H1 --}}
# 🔐 Iniciar Sessão - Mimoquices

@if (! empty($greeting))
# {{ $greeting }}
@else
**Bem-vindo de volta!** Recebemos um pedido para redefinir a sua palavra-passe.
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}
@endforeach

{{-- Botão Principal (simulando o teu btn-submit) --}}
@isset($actionText)
@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}
@endforeach

{{-- Rodapé / Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
Atentamente,<br>
**Equipa Mimoquices**
@endif

{{-- Subcopy: Link direto --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "Se tiver problemas ao clicar no botão \":actionText\", copie e cole o URL abaixo no seu navegador:",
    [
        'actionText' => $actionText,
    ]
)  
<span class="break-all">[{{ $actionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent