{{--
file: resources/views/_index-card.blade.php
author: Ian Kollipara
date: 2024-08-12
description: A card for the index page.
 --}}

@php
  $iconComponent = "tabler-$icon";
@endphp

<div class="flex gap-x-4 rounded-xl bg-white/5 p-6 ring ring-inset ring-white/10">
  <x-dynamic-component class="h-7 w-5 flex-none text-cune-wheat"
                       :component="$iconComponent" />
  <div class="text-base leading-7">
    <h3 class="font-semibold text-white">{{ $title }}</h3>
    <p class="mt-2 text-gray-300">
      {{ $description }}
    </p>
  </div>
</div>
