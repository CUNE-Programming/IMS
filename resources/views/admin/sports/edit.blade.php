{{--
file: resources/views/admin/sports/edit.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The edit view for the sports in the admin panel.
 --}}

@props(["sport"])

@php
  $title = "IMS Admin | Edit Sport";
@endphp

<x-layouts.admin :title="$title">
  <div class="flex flex-col gap-1">
    <div class="flex w-full justify-between">
      <h1 class="text-3xl">Edit Sport</h1>
      <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
         href="{{ route("admin.sports.index") }}">
        <i class="size-4"
           data-lucide="arrow-left"></i>
        Go Back
      </a>
    </div>
    @include("admin.sports._form", [
        "sport" => $sport,
        "btnText" => "Update Sport",
        "method" => "PUT",
        "route" => route("admin.sports.update", $sport),
    ])
    <h2 class="text-2xl">Variants</h2>
    <ul class="space-y-3">
      @foreach ($sport->variants as $variant)
        <li class="group rounded px-2 py-1 font-cune-sub shadow ring-1 ring-gray-300">
          <a class="flex w-full items-center"
             href="#">
            {{ $variant->name }}
            <i class="size-4 opacity-0 transition-all group-hover:translate-x-5 group-hover:opacity-100 group-hover:duration-100"
               data-lucide="arrow-right"></i>
          </a>
        </li>
      @endforeach
    </ul>
  </div>
</x-layouts.admin>
