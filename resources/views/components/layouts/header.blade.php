{{--
file: resources/views/components/layouts/header.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The header component for the layout.
 --}}

@props(["wrapperClass" => [], "text" => ""])

<header class="bg-white shadow">
  <div @class(array_merge(
          ["mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8"],
          explode_if_string($wrapperClass)))>
    @if ($slot->isEmpty())
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $text }}</h1>
    @else
      {{ $slot }}
    @endif
  </div>
</header>
