@props(['active', 'icon', 'label', 'href'])

@php
    $classes =
        $active ?? false
            ? 'bg-green-500 text-white shadow-lg shadow-green-900/20'
            : 'text-green-100 hover:bg-green-700/50 hover:text-white transition-all';
@endphp

<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'flex items-center gap-3 px-4 py-3 rounded-2xl font-bold text-sm ' . $classes]) }}>
    <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
    <span>{{ $label }}</span>
</a>
