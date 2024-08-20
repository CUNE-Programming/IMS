{{--
file: resources/views/components/layouts/_guest_navbar.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The guest navbar for the guest panel.
 --}}

@php
  $classes ??= [];
@endphp

<nav data-controller="mobile-menu"
     @class([
         "fixed z-10 w-full bg-transparent" => request()->routeIs("index"),
         "w-full bg-cune-blue" => !request()->routeIs("index"),
         ...$classes,
     ])>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="flex h-16 w-full items-center justify-between">
      <div class="flex w-full items-center">
        <div class="flex-shrink-0">
          <x-logo.icon class="size-8" />
        </div>
        <div class="hidden md:block">
          <div class="ml-10 flex items-baseline space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            @foreach ($links as $link)
              <a href="{{ $link["href"] }}"
                 @class([
                     "rounded-md",
                     "bg-gray-900 text-white" => request()->routeIs($link["route"]),
                     "text-gray-300" => !request()->routeIs($link["route"]),
                     "hover:text-white",
                     "hover:bg-gray-700",
                     "px-3",
                     "py-2",
                     "text-sm",
                     "font-medium",
                     "text-white",
                 ])>{{ $link["text"] }}</a>
            @endforeach
          </div>
        </div>
      </div>
      <div class="-mr-2 flex md:hidden">
        <!-- Mobile menu button -->
        <button class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                data-action="mobile-menu#toggleMenu"
                type="button"
                aria-controls="mobile-menu"
                aria-expanded="false">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <!-- Menu open: "hidden", Menu closed: "block" -->
          <svg class="block h-6 w-6"
               data-mobile-menu-target="hideIcon"
               aria-hidden="true"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <!-- Menu open: "block", Menu closed: "hidden" -->
          <svg class="hidden h-6 w-6"
               data-mobile-menu-target="showIcon"
               aria-hidden="true"
               fill="none"
               viewBox="0 0 24 24"
               stroke-width="1.5"
               stroke="currentColor">
            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Mobile menu, show/hide based on menu state. -->
  <div class="hidden h-[100vh] bg-gray-800 md:hidden"
       id="mobile-menu"
       data-mobile-menu-target="menu">
    <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
      @foreach ($links as $link)
        <a href="{{ $link["href"] }}"
           @class([
               "block rounded-md px-3 py-2 text-base font-medium  hover:bg-gray-700 hover:text-white",
               "bg-gray-900 text-white" => request()->routeIs($link["route"]),
               "text-gray-300" => !request()->routeIs($link["route"]),
           ])>{{ $link["text"] }}</a>
      @endforeach
    </div>
  </div>
</nav>
