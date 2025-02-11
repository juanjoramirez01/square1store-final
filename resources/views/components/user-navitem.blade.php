@if(Auth::user())
    <div class="bg-primary/10 border border-primary size-5 rounded-full flex justify-center items-center p-1 box-content">
        <p class="text-primary font-black">{{Auth::user()->name[0]}}</p>
    </div>
@else
        <x-svg-user class="size-6 text-black hover:text-primary" />
@endif
