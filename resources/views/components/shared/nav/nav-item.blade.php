@props(['href'])

<li><a wire:navigate href="{{$href}}" class="text-2xl md:text-4xl lg:text-lg font-medium link-hover">{{$slot}}</a></li>