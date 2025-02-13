<header x-data="{ isOpen: false }">
    <div class="wrapper border-b md:border-b-0">
        <div class="flex justify-between items-center gap-4 py-4 md:py-6 box-border">
            <div class="flex items-end gap-4">
                <button x-on:click="$dispatch('open-modal', 'mobile-nav')"
                    class="group hover:border-black border rounded p-2 box-border hover:bg-neutral-100 transition-all duration-200 md:hidden">
                    <x-header.svg-bars3 class="size-6 text-neutral-500 group-hover:text-black transition-all duration-200" />
                </button>
                <a href="{{route('home')}}">
                    <span class="sr-only">{{config('app.name')}}</span>
                    <img src="{{asset('images/sq1-logo.svg')}}" alt="{{__(config('app.name'))}}" width="120" height="37" />
                </a>
            </div>
            <div class="w-fit xs:flex justify-end items-center gap-4 hidden">
                <x-header.search-button />
                <x-header.user-navitem />
                <x-header.shopping-cart-button />
            </div>
        </div>
    </div>
    <nav class="bg-neutral-100 w-full py-2 box-border border-y hidden md:block">
        <div class="wrapper max-w-4xl flex justify-around items-center gap-4">
            @foreach(config('navigation') as $item)
                <a href="" class="uppercase font-bold text-sm text-black hover:text-primary">
                    {{__($item['title'])}}
                </a>
            @endforeach
        </div>
    </nav>

    <template x-teleport="#aside-modal" x-show="isOpen">
        <x-modals.modal name="mobile-nav" :maxWidth="null" :fullscreen="true">
            <x-modals.modal-card class="w-screen min-h-screen rounded-none pt-0 px-0 sm:p-0 flex flex-col" x-effect="window.addEventListener('resize', () => { if (window.innerWidth > 768) $dispatch('close-modal', 'mobile-nav') })">
                <div class="flex items-end gap-4 border-b py-5 px-4">
                    <button x-on:click="$dispatch('close-modal', 'mobile-nav')"
                            class="group hover:border-black border rounded p-2 box-border hover:bg-neutral-100 transition-all duration-200">
                        <x-modals.svg-x-mark class="size-6 text-neutral-500 group-hover:text-black transition-all duration-200" />
                    </button>
                    <a href="{{route('home')}}">
                        <span class="sr-only">{{config('app.name')}}</span>
                        <img src="{{asset('images/sq1-logo.svg')}}" alt="{{config('app.name')}}" width="120" height="37" />
                    </a>
                </div>
                <div class="px-4 pt-5 pb-4 flex-1">
                    <nav class="flex flex-col">
                        @foreach(config('navigation') as $item)
                            <a href="" class="uppercase font-bold text-sm text-black hover:text-primary border-b px-6 py-4 hover:bg-neutral-100">
                                {{__($item['title'])}}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </x-modals.modal-card>
        </x-modals.modal>
    </template>
</header>