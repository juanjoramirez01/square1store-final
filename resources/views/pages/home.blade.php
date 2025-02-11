<x-guest-layout>
    <main class="flex-1">
        <div class="py-16 box-border">
            <div class="wrapper hidden lg:flex justify-between items-center gap-4">
                @foreach(collect(File::allFiles('images/brands'))->shuffle() as $image)
                    <img src="{{ $image }}" alt="" class="w-full h-auto max-w-[196px]">
                @endforeach
            </div>

            <x-marquee class="lg:hidden">
                @foreach(collect(File::allFiles('images/brands')) as $image)
                    <img src="{{ $image }}" alt="" class="w-full h-auto max-w-[120px]">
                @endforeach
            </x-marquee>
        </div>

        <div class="bg-neutral-50 py-20 box-border">
            <livewire:recommended-products-section/>
        </div>
    </main>
</x-guest-layout>
