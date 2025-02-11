<div {{$attributes}} x-cloak x-data="{ open: false }" @keydown.escape="open = false" class="relative flex">
    <button x-on:click="open = !open" type="button" x-show="!open" class="group hover:border-black border border-transparent rounded p-1.5 box-border hover:bg-neutral-100 transition-all">
        <x-svg-search class="size-6 text-black hover:text-primary" />
    </button>

    <div x-cloak class="flex items-end gap-2 overflow-hidden transition-all duration-200" x-bind:class="{ 'w-auto': open, 'w-0': !open }">
        <button x-show="open" x-transition x-on:click="open = false" type="button" class="size-9 group hover:border-black border border-transparent rounded px-1.5 box-border hover:bg-neutral-100 transition-all">
            <x-svg-x-mark class="size-5 text-black group-hover:text-primary m-auto" />
        </button>
        <form>
            <div>
                <x-form.input-label for="search" class="sr-only">{{__('Search')}}</x-form.input-label>
                <x-form.input
                    class="block mt-1 w-full"
                    id="search"
                    type="search"
                    name="search"
                    required
                    autofocus
                    autocomplete="search"
                    placeholder="{{__('Search for products')}}"
                />
            </div>
        </form>
    </div>
</div>
