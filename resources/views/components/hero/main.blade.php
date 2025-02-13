@props(['class' => ''])

<h1 {{ $attributes->merge(['class' => 'text-4xl md:text-5xl font-bold text-black uppercase leading-tight ' . $class]) }}>
    {{ $slot }}
</h1>