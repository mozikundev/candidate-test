@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex h-16 items-center border-b-2 border-emerald-700 px-1 text-sm font-semibold text-emerald-700'
    : 'inline-flex h-16 items-center border-b-2 border-transparent px-1 text-sm font-medium text-slate-500 hover:border-emerald-300 hover:text-emerald-700';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>