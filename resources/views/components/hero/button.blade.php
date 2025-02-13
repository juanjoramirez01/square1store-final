@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-block px-8 py-3 border-2 border-gray-800 text-gray-800 hover:bg-gray-800 hover:text-white rounded-lg transition-all duration-300 font-semibold']) }}>
    {{ $slot }}
</a>