@props(['product'])

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden transition-shadow hover:shadow-lg">
    <div class="h-64 overflow-hidden">
        <img 
            src="{{ $product->image }}" 
            alt="{{ $product->name }}"
            class="w-full h-full object-cover"
        >
    </div>
    
    <div class="p-6 space-y-4">
        <h3 class="text-xl font-semibold text-gray-900">{{ $product->name }}</h3>
        <span class="text-sm text-gray-500">{{ $product->brand }}</span>
        
        <div class="flex items-baseline gap-3">
            <span class="text-2xl font-bold text-primary">${{ $product->price }}</span>
            @if($product->old_price)
                <span class="text-gray-400 line-through">${{ $product->old_price }}</span>
            @endif
        </div>
        
        <div class="flex gap-2">
            @foreach($product->colors as $color)
                <span 
                    class="w-7 h-7 rounded-full border-2 border-transparent hover:border-primary cursor-pointer"
                    style="background-color: {{ $color }}"
                ></span>
            @endforeach
        </div>
        
        <button class="w-full py-3 border-2 border-primary text-primary rounded-lg hover:bg-primary hover:text-white transition">
            Buy Now
        </button>
    </div>
</div>