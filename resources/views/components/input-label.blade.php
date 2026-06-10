@props(['value' => null])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{-- 1. Se passares um valor por propriedade, ele mostra o texto primeiro --}}
    @if($value)
        <span>{{ $value }}</span>
    @endif

    {{-- 2. O slot aqui vai receber o <input> e/ou qualquer texto extra vindo da view --}}
    {{ $slot }}
</label>
