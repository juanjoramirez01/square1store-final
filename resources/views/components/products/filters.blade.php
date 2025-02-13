<div>
    <div class="hidden lg:flex gap-4 justify-center mb-8">
        @foreach($categories as $category)
            <button 
                wire:click="toggleCategory('{{ $category }}')"
                class="px-6 py-2 rounded-full {{ in_array($category, $selectedCategories) ? 'bg-primary text-white' : 'bg-gray-100 text-gray-800' }}"
            >
                {{ $category }}
            </button>
        @endforeach
    </div>
    
    <select class="lg:hidden w-full max-w-xs mx-auto mb-8" wire:model="selectedCategories">
        <option value="">All Categories</option>
        @foreach($categories as $category)
            <option value="{{ $category }}">{{ $category }}</option>
        @endforeach
    </select>
</div>