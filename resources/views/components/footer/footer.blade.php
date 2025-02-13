<footer class="border-t">
    <div class="wrapper flex flex-col-reverse md:flex-row md:justify-between items-center gap-4 py-6 box-border">
        <a href="{{ route('home') }}">
            <img src="{{asset('images/sq1-logo.svg')}}" alt="{{config('app.name')}}" width="90" height="28" />
        </a>
        <div class="flex justify-center md:justify-end items-center gap-y-2 gap-x-4 md:gap-4 flex-wrap">
            @foreach([__('support center'), __('invoicing'), __('contract'), __('careers'), __('blog'), __('faq')] as $item)
                <a href="" class="capitalize text-black hover:text-primary opacity-70 hover:opacity-100">{{$item}}</a>
            @endforeach
        </div>
    </div>
</footer>