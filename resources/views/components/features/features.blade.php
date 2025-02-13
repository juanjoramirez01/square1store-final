@props(['features' => [
    [
        'icon' => 'high-quality',
        'title' => 'High Quality',
        'description' => 'Crafted from top materials'
    ],
    [
        'icon' => 'warranty',
        'title' => 'Warranty Protection',
        'description' => 'Over 2 years'
    ],
    [
        'icon' => 'shipping',
        'title' => 'Free Shipping',
        'description' => 'Order over $150'
    ],
    [
        'icon' => 'support',
        'title' => '24/7 Support',
        'description' => 'Dedicated support'
    ]
]])

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($features as $feature)
                <x-features.item 
                    :icon="$feature['icon']"
                    :title="$feature['title']"
                    :description="$feature['description']"
                />
            @endforeach
        </div>
    </div>
</section>