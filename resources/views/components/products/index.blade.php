@props(['products', 'categories'])

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <x-products.header 
            title="New Arrivals" 
            description="Discover our exciting new arrivals..."
        />
        
        <livewire:products.filters :categories="$categories"/>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-12">
            @foreach($products as $product)
                <x-products.card :product="$product"/>
            @endforeach
        </div>
        
        <x-products.end-button class="mt-12"/>
    </div>
</section>