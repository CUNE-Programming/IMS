{{--
file: resources/views/admin/coordinators/index.blade.php
author: Ian Kollipara
date: 2024-07-20
description: The index view for the coordinators in the admin panel.
 --}}

@props(["coordinators"])

@php
  $title = "IMS Admin | Coordinators";
@endphp

<x-layouts.admin class=""
                 :title="$title"
                 html-class="bg-cune-white">
  <div class="mb-3 flex w-full">
    <h1 class="text-2xl font-semibold">Coordinators</h1>
    <a class="ml-auto rounded-lg bg-cune-blue px-3 py-2 text-sm font-semibold text-cune-white hover:bg-gray-900"
       href="{{ route("admin.coordinators.create") }}">Add Coordinator</a>
  </div>
  <table class="w-full table-auto">
    <tbody class="">
      @foreach ($coordinators as $user)
        <tr class="mb-2 table-row w-full items-center gap-3 border-b border-solid border-gray-500 pb-1 last:border-0">
          <td>
            <img class="size-8 rounded-full"
                 src="{{ $user->avatar }}"
                 alt="{{ $user->name }}">
          </td>
          <td class="flex flex-col pb-3 font-cune-text text-lg">
            <div>
              {{ $user->name }}
              <span class="italic text-gray-500">({{ $user->email }})</span>
            </div>
            <div class="flex gap-1">
              @foreach ($user->coordinators as $coordinator)
                <p class="self-center rounded-lg bg-cune-wheat px-2 text-sm font-semibold">
                  {{ $coordinator->variant->name }}
                </p>
              @endforeach
            </div>
          </td>
          <td>
            <x-tabler-x class="hover:cursor-pointer hover:text-gray-700"
                        data-modals-modal-id-param="coordinator_{{ $user->id }}"
                        data-lucide="x"
                        x-on:click="$dispatch('show-modal', 'coordinator_{{ $user->id }}')"></x-tabler-x>
          </td>
        </tr>
        @push("modals")
          <x-modal title="Remove {{ $user->name }} as Coordinator?"
                   modal-id="coordinator_{{ $user->id }}">
            <form class="flex flex-col"
                  action="{{ route("admin.coordinators.destroy", $coordinator) }}"
                  method="post">
              @csrf
              @method("DELETE")
              <div class="flex flex-col">
                <label class="font-cune-sub"
                       for="admin-coordinators--coordinator_ids">Select which variants to remove {{ $user->name }} as
                  coordinator from:</label>
                <select class="rounded border-none font-cune-text focus:ring-cune-wheat"
                        id="admin-coordinators--coordinator_ids"
                        name="coordinator_id[]"
                        multiple>
                  @foreach ($user->coordinators as $coordinator)
                    <option value="{{ $coordinator->id }}">{{ $coordinator->variant->name }}</option>
                  @endforeach
                </select>
              </div>
              <button class="pill-btn"
                      type="submit">Submit</button>
            </form>
          </x-modal>
        @endpush
      @endforeach
    </tbody>
  </table>
  {{ $coordinators->links() }}
</x-layouts.admin>
