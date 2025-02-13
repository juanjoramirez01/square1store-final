@props(['href' => '#'])

<a href="{{ $href }}" class="inline-block px-8 py-3 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors font-medium">
    {{ $slot }}
</a>