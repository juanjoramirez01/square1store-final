@props(['class' => ''])

<div {{ $attributes->merge(['class' => 'text-center text-white space-y-6 ' . $class]) }}>
    {{ $slot }}
</div>