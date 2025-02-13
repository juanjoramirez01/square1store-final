@props(['image' => 'images/banners/banner.png'])

<section class="relative bg-cover bg-center" style="background-image: url('{{ asset($image) }}')">
    <div class="bg-black bg-opacity-50">
        <div class="container mx-auto px-4 py-28 text-center">
            <x-banner.text>
                <h3 class="text-2xl font-medium mb-4">Extra 30% Off Online</h3>
                <h2 class="text-4xl font-bold mb-6">Summer Season Sale</h2>
                <p class="max-w-2xl mx-auto text-lg mb-8">
                    Enjoy 30% off summer essentials—clothes, gear, and more. Shop now for huge savings before it’s over!
                </p>
                <x-banner.button href="#">
                    Shop Now
                </x-banner.button>
            </x-banner.text>
        </div>
    </div>
</section>