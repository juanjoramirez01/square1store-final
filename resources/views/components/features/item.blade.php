@props(['icon', 'title', 'description'])

<div class="flex items-center gap-4 p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
    <div class="flex-shrink-0">
        <img src="{{ asset('images/features/' . $icon . '.png') }}" alt="{{ $title }} Icon" class="w-10 h-10">
    </div>
    <div>
        <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>
        <p class="text-gray-600 mt-1">{{ $description }}</p>
    </div>
</div>
