@props(['image' => 'images/banners/model-man.png'])

<section class="bg-[#DBD0CC] py-16">
    <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between gap-12">
        <div class="md:w-1/2 space-y-8">
            <x-hero.header>Hot deals this week</x-hero.header>
            <x-hero.main>Sale up 50%<br>Modern Furniture</x-hero.main>
            <x-hero.button href="#">View Now</x-hero.button>
        </div>
        
        <div class="md:w-1/2 hidden md:block">
            <img src="{{ asset($image) }}" alt="Hero" class="w-full h-auto">
        </div>
    </div>
</section>