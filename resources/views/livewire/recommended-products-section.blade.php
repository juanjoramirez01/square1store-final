<div class="wrapper space-y-10">
    <div class="space-y-2">
        <h2 class="text-black font-black text-5xl text-center">
            {{__('New arrivals')}}
        </h2>

        <p class="text-pretty text-black text-center sm:max-w-lg mx-auto">
            {{__('Discover our exciting new arrivals, featuring the latest trends and styles to refresh your wardrobe this season.')}}
        </p>
    </div>

    <div class="hidden min-[930px]:flex justify-center items-center gap-6 lg:gap-10 transition-all">
        @foreach($categories as $category)
            <button type="button"
                    wire:click="selectCategory('{{$category->slug}}')"
                    wire:key="category-{{$category->slug}}"
                @class([
                    'btn btn-filled capitalize',
                    'btn-gray hover:border-primary hover:!bg-primary/5 hover:!text-primary' => $selectedCategory->id !== $category->id,
                    'btn-primary shadow-xl shadow-primary/20' => $selectedCategory->id === $category->id,
                ])
            >
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div class="min-[930px]:hidden">
        <form class="w-full">
            <div class="w-full">
                <x-form.input-label for="filter-products">{{__('Filter by')}}</x-form.input-label>
                <x-form.select class="w-full" id="filter-products" name="filter-products">
                    <option value="">{{__('Men\'s Fashion')}}</option>
                    <option value="">{{__('Women\'s Fashion')}}</option>
                    <option value="">{{__('Men\'s Accessories')}}</option>
                    <option value="">{{__('Women\'s Accessories')}}</option>
                    <option value="">{{__('Discounts deals')}}</option>
                </x-form.select>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 lg:gap-8">
        @foreach($selectedCategory->products->take(4) as $product)
            <x-product-card :product="$product"/>
        @endforeach
    </div>
</div>
