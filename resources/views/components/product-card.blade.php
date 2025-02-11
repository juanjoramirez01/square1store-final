<div {{ $attributes->merge(['class' => 'bg-white border rounded-md p-4 py-5 box-border hover:shadow transition flex flex-col']) }}>
    <a href="" class="w-full aspect-square bg-neutral-800 block rounded-md">
        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="object-cover w-full h-full rounded-md aspect-square">
    </a>
    <a href="" class="block mt-2 flex-1">
        <h3 class="text-xl text-black font-semibold capitalize">{{ $product->name }}</h3>
            @isset($product->brand)
                <p class="text-sm text-neutral-500 capitalize">{{ $product->brand }}</p>
            @endisset

        <div class="flex justify-start items-baseline mt-2 gap-1">
            <span class="text-black text-xl font-bold">$ {{ $product->sale_price ?? $product->price }}</span>
            @isset($product->sale_price)
            <span class="text-neutral-400 line-through font-medium">$ {{ $product->price }}</span>
            @endisset
        </div>

        <div class="flex justify-start items-start flex-wrap gap-x-4 gap-y-2 mt-4">
            @foreach($product->colors as $color)
                <div class="size-6 rounded-full border border-transparent" style="background-color: {{ $color }}"></div>
            @endforeach
        </div>
    </a>
    <button class="btn btn-outlined btn-primary w-full mt-4">
        {{__('Add to cart')}}
    </button>
</div>
