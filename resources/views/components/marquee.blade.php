<!-- Marquee -->
<!-- An Alpine.js and Tailwind CSS component by https://pinemix.com -->
<div
    x-data="{
    // Marquee options
    pauseOnHover: false,

    // Initialization
    init() {
      // Clone the Marquee list and append it to the marquee track (we need 2 full width tracks for the Marquee animation to work correctly)
      this.$nextTick(() => {
        this.$refs.marqueeTrack.appendChild(this.$refs.marqueeList.cloneNode(true));
      });
    }
  }"
    {{$attributes->merge(['class' => 'relative overflow-hidden bg-white py-10'])}}
>
    <!-- Marquee overlay gradients -->
    <div
        class="absolute inset-y-0 start-0 z-10 w-32 bg-gradient-to-r from-white to-transparent rtl:bg-gradient-to-l"
        aria-hidden="true"
    ></div>
    <div
        class="absolute inset-y-0 end-0 z-10 w-32 bg-gradient-to-l from-white to-transparent rtl:bg-gradient-to-r"
        aria-hidden="true"
    ></div>
    <!-- END Marquee overlay gradients -->

    <!-- Marquee Track -->
    <div
        x-ref="marqueeTrack"
        class="animate-full-tl rtl:animate-full-tr relative flex w-full"
        x-bind:class="{ 'hover:[animation-play-state:paused]': pauseOnHover }"
    >
        <!-- Marquee list -->
        <div
            x-ref="marqueeList"
            class="flex w-full flex-shrink-0 flex-nowrap items-center justify-around gap-10 px-5"
        >
            <!-- Marquee Items -->
            <!--
              Add your content here but make sure that it renders correctly on all screen sizes based on the available width
             (for the Marquee to work correctly, the track width is always 100% of the available container width, so your content should fit accordingly)
            -->
            {{$slot}}
            <!-- END Marquee Items -->
        </div>
        <!-- END Marquee List -->
    </div>
    <!-- END Marquee Track -->
</div>
<!-- END Marquee -->
