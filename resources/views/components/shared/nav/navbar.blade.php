<nav class="flex justify-between items-center max-w-screen-max  px-6 xs:12 sm:px-16 py-2 lg:py-4  mx-auto   bg-primary-400 rounded-xl shadow-2xl">

{{-- left side --}}
<div class="flex items-center gap-16">

    <a wire:navigate href="{{route('home')}}" class="flex items-center gap-3 group">
        <img src="{{asset('assets/logo.webp')}}" alt="logo gameend" class="w-[3.2rem]">
        <span class="mb-[2px] text-lg font-heading font-medium group-hover:text-secondary-400 duration-500">game<span class="text-secondary-400 group-hover:text-fontPrimary duration-500">end</span></span>

    </a>

<x-shared.nav.nav-list class="hidden lg:flex items-center gap-8"/>

</div>


{{-- right side --}}
@if (auth()->check())
<div class="hidden lg:block">

    <x-base.link-btn href="/admin">admin</x-base.link-btn>
</div>
@else
    <x-shared.nav.socials class="hidden lg:flex gap-4"/>
@endif

<button class="lg:hidden hamburger hamburger--stand " type="button">
    <span class="hamburger-box">
      <span class="hamburger-inner"></span>
    </span>
  </button>  

</nav>


{{-- mobile menu --}}
<div class="mobile-menu fixed lg:hidden left-3 top-[103px] right-3 bottom-3 bg-primary-600 translate-y-[110%] duration-500 ease-in-out rounded-xl z-50">

    <nav class="flex flex-col justify-center items-center gap-6 md:gap-12 h-full w-full">

        <x-shared.nav.nav-list class="flex flex-col items-center gap-10 md:gap-16"/>

        <x-shared.nav.socials class="gap-4"/>
    </nav>

</div>