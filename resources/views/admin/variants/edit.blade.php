{{--
file: resources/views/admin/variants/edit.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The edit view for the variants in the admin panel.
 --}}

@props(["variant"])

@php
  $title = "IMS Admin | Edit Variant";
@endphp

<x-layouts.admin :title="$title">
  <div class="flex w-full justify-between">
    <h1 class="text-3xl">Edit Variant</h1>
    <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
       href="{{ route("admin.variants.index") }}">
      <x-tabler-arrow-left class="size-4"
                           data-lucide="arrow-left"></x-tabler-arrow-left>
      Go Back
    </a>
  </div>
  @include("admin.variants._form", [
      "variant" => $variant,
      "btnText" => "Update Variant",
      "method" => "PUT",
      "route" => route("admin.variants.update", $variant),
  ])
  <div class="grid h-full grid-cols-1 gap-3 md:grid-cols-2">
    <div>
      <h2 class="text-2xl">Seasons</h2>
      <hr>
      <ul class="h-full list-inside list-disc space-y-3 px-2">
        @foreach ($variant->seasons as $season)
          <li class="rounded border-b-2 border-gray-300 py-1 font-cune-text last:border-b-0">
            {{ $season->name }}
          </li>
        @endforeach
      </ul>
    </div>
    <div>
      <h2 class="text-2xl">Coordinators</h2>
      <hr>
      <ul class="h-full list-inside list-disc space-y-3 rounded px-2">
        @foreach ($variant->coordinators as $coordinator)
          <li class="rounded border-b-2 border-gray-300 py-1 font-cune-text last:border-b-0">
            {{ $coordinator->name }}
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  </div>
</x-layouts.admin>
