{{--
file: resources/views/admin/sports/create.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The create view for the sports in the admin panel.
 --}}

@php
  use App\Models\Sport;
  $title = "IMS Admin | Create Sport";
  $sport = new Sport();
@endphp

<x-layouts.admin :title="$title">
  <div class="flex flex-col gap-1">
    <div class="flex w-full justify-between">
      <h1 class="text-3xl">Create Sport</h1>
      <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
         href="{{ route("admin.sports.index") }}">
        <x-tabler-arrow-left class="size-4"
                             data-lucide="arrow-left"></x-tabler-arrow-left>
        Go Back
      </a>
    </div>
    @include("admin.sports._form", [
        "sport" => $sport,
        "btnText" => "Create",
        "method" => "POST",
        "route" => route("admin.sports.store"),
    ])
  </div>
</x-layouts.admin>
