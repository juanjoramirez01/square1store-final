<select {{ $attributes->merge(['class' => "w-full rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-base focus:border-teal-600 focus:outline-none focus:ring-1 focus:ring-teal-600 sm:text-sm"]) }}>
    {{ $slot }}
</select>
