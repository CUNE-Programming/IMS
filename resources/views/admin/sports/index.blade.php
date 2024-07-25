{{--
file: resources/views/admin/sports/index.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The index view for the sports in the admin panel.
 --}}

@props(["sports"])

@php
  $title = "IMS Admin | Sports";
@endphp

<x-layouts.admin :title="$title">
  <div class="mb-3 flex w-full">
    <h1 class="text-2xl font-semibold">Sports</h1>
    <a class="ml-auto rounded-lg bg-cune-blue px-3 py-2 text-sm font-semibold text-cune-white hover:bg-gray-900"
       href="{{ route("admin.sports.create") }}">Add Sport</a>
  </div>
  <div class="mb-3 grid grid-cols-2 gap-3 md:grid-cols-3 xl:grid-cols-4">
    @forelse ($sports as $sport)
      <div class="rounded bg-gray-300/50 px-3 py-2 shadow ring-1 ring-gray-300">
        <div class="flex items-baseline justify-between">
          <h2 class="text-xl">{{ $sport->name }}</h2>
          <p class="italic"># of Variants: {{ $sport->variants_count }}</p>
        </div>
        <figure class="h-52">
          <img class="h-full w-full rounded object-cover"
               src="{{ $sport->image }}"
               alt="{{ $sport->name }}">
        </figure>
        <div class="my-2 flex gap-2">
          <a class="btn"
             href="{{ route("admin.sports.edit", $sport) }}">
            Edit
          </a>
        </div>
      </div>
    @empty
    @endforelse
  </div>
  {{ $sports->links() }}
</x-layouts.admin>
