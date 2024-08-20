{{--
file: resources/views/components/layouts/guest.blade.php
author: Ian Kollipara
date: 2024-08-12
description: The primary wrapper for all views in the guest panel.
 --}}

@props(["navbarClass" => []])

@php
  $links = [
      ["href" => route("index"), "route" => "index", "text" => "Home"],
      ["href" => "https://cune-programming.github.io", "route" => "", "text" => "About"],
      ["href" => route("contact-us.create"), "route" => "contact-us.create", "text" => "Contact Us"],
      ["href" => "#", "route" => "", "text" => "All Sports"],
  ];
  $navbarClass = explode_if_string($navbarClass);
@endphp

<x-layouts.app title="CUNE IMS"
               {{ $attributes }}>
  @include("components.layouts._guest_navbar", ["links" => $links, "classes" => $navbarClass])
  {{ $slot }}
</x-layouts.app>
