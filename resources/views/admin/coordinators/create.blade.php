{{--
file: resources/views/admin/coordinators/create.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The create view for the coordinators in the admin panel.
 --}}

@props(["variants", "users"])

@php
  use App\Enums\ClassStanding;
  use App\Enums\Gender;
  $title = "IMS Admin | Add Coordinator";
  $enumToSelect = fn($enum) => collect($enum::cases())->map(fn($case) => [$case->value => $case->label])->flatten();
@endphp

<x-layouts.admin class=""
                 :title="$title"
                 html-class="bg-cune-white">
  <div class="flex w-full justify-between">
    <h1 class="text-3xl">Add Coordinator</h1>
    <div class="flex gap-1">
      <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
         href="{{ route("admin.coordinators.index") }}">
        <x-tabler-arrow-left class="size-4"
                             data-lucide="arrow-left"></x-tabler-arrow-left>
        Go Back
      </a>
    </div>
  </div>
  <x-form route='{{ route("admin.coordinators.store") }}'
          method="post">
    <x-form.select name="variant_id"
                   label="Sport Variant"
                   :options="$variants"
                   help="Choose the sport variant to create a coordinator for. The numbers signify the total number of coordinators for that variant."
                   required />
    <div class="flex">
      <x-form.select name="user_id"
                     wrapper-class="flex-1 flex flex-col"
                     label="User"
                     :options="$users"
                     help="Choose the user to make a coordinator. The numbers signify the total number of variants that user coordinates. Use the '+' to create a new user."
                     required />
      <button class="my-auto flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
              type="button"
              x-on:click="$dispatch('show-modal', 'addUserModal')">
        Add User
      </button>
    </div>
  </x-form>
  @push("modals")
    <x-modal title="Add User"
             modal-id="addUserModal">
      <x-form route='{{ route("admin.users.store") }}'
              method="post">
        <x-form.input name="name"
                      label="Name"
                      required />
        <x-form.input name="email"
                      type="email"
                      label="Email"
                      required />
        <x-form.select name="class_standing"
                       label="Class Standing"
                       :options="$enumToSelect(ClassStanding::class)"
                       required />
        <x-form.select name="gender"
                       label="Gender"
                       :options="$enumToSelect(Gender::class)"
                       required />
      </x-form>
    </x-modal>
  @endpush
</x-layouts.admin>
