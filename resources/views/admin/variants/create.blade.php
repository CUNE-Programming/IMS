{{--
file: resources/views/admin/variants/create.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The create view for the variants in the admin panel.
 --}}

@php
  use App\Models\Variant;
  $title = "IMS Admin | Create Variant";
  $variant = new Variant();
@endphp

<x-layouts.admin :title="$title">
  <div class="flex w-full justify-between">
    <h1 class="text-3xl">Create Variant</h1>
    <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
       href="{{ route("admin.variants.index") }}">
      <i class="size-4"
         data-lucide="arrow-left"></i>
      Go Back
    </a>
  </div>
  <div class="flex flex-col gap-1">
    @include("admin.variants._form", [
        "variant" => $variant,
        "btnText" => "Create",
        "method" => "POST",
        "sports" => $sports,
        "route" => route("admin.variants.store"),
    ])

  </div>
</x-layouts.admin>
