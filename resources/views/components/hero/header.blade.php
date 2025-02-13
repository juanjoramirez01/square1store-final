@props(['class' => ''])

<span {{ $attributes->merge(['class' => 'uppercase text-gray-800 text-lg tracking-wider ' . $class]) }}>
    {{ $slot }}
</span>