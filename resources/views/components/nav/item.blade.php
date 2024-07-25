{{--
file: resources/views/components/nav/item.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The navigation item component for the admin panel.
 --}}

@props(["route", "routeParams" => [], "icon"])

@php
  $isActive = Route::currentRouteName() === $route;
@endphp

<li>
  <a href="{{ route($route, $routeParams) }}"
     @class([
         "bg-gray-700" => $isActive,
         "text-gray-300" => !$isActive,
         "text-cune-white" => $isActive,
         "flex",
         "gap-3",
         "rounded-md",
         "p-2",
         "text-sm",
         "font-semibold",
         "leading-6",
         "hover:bg-gray-700",
         "hover:text-cune-white",
     ])>
    <i class="size-5 flex-shrink-0"
       data-lucide="{{ $icon }}"></i>
    {{ $slot }}
  </a>
</li>
