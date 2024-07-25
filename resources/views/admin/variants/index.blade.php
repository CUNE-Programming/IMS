{{--
file: resources/views/admin/variants/index.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The index view for the variants in the admin panel.
 --}}

@props(["variants"])

@php
  $title = "IMS Admin | Variants";
@endphp

<x-layouts.admin :title="$title">
  <div class="mb-3 flex w-full">
    <h1 class="text-2xl font-semibold">Variants</h1>
    <a class="ml-auto rounded-lg bg-cune-blue px-3 py-2 text-sm font-semibold text-cune-white hover:bg-gray-900"
       href="{{ route("admin.variants.create") }}">Add Variant</a>
  </div>
  @forelse ($variants as $variant)
    <div class="mb-3 flex flex-1 items-center justify-between rounded px-2 py-2 outline outline-gray-300">
      <div class="flex items-baseline gap-3">
        <h2 class="text-xl">{{ $variant->name }}</h2>
        <p class="italic">{{ $variant->sport->name }}</p>
      </div>
      <div class="flex space-x-2">
        <p class="italic">
          @if ($variant->has_active_season)
            <span>(Active)</span>
          @endif
          # of Seasons: {{ $variant->seasons_count }}
        </p>
        <a class="rounded bg-cune-wheat px-1 font-cune-text text-cune-blue transition-colors hover:bg-cune-blue hover:text-cune-wheat"
           href="{{ route("admin.variants.edit", $variant) }}">Edit</a>
      </div>
    </div>
  @empty
  @endforelse
</x-layouts.admin>
