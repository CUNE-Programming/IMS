{{--
file: resources/views/coordinator/seasons/show.blade.php
author: Ian Kollipara
date: 2024-08-08
description: The show/manage page for a season in the coordinator panel.
 --}}

<x-layouts.coordinator title="IMS Coordinator | Seasons">
  <div class="flex items-center justify-between">
    <h1 class="text-2xl font-semibold">Manage {{ $season->name }}</h1>
    <div class="flex gap-6">
      <button class="btn"
              data-action="modals#showModal"
              data-modals-modal-id-param="AddGameModal">
        Add Game
      </button>
      <a class="btn"
         href="">
        Manage Players
      </a>
      <a class="btn"
         href="">
        Manage Teams
      </a>
    </div>
  </div>
  <div class="mt-3"
       data-controller="calendar"
       data-calendar-left-header-value="title"
       data-calendar-center-header-value=""
       data-calendar-right-header-value=""
       data-calendar-height-value="70vh"
       data-calendar-feed-url-value="">
    <div data-calendar-target="calendar"></div>
  </div>
  @push("modals")
    <x-modal title="Add Game"
             modal-id="AddGameModal">
      <x-form route='{{ route("coordinator.seasons.games.store", $season) }}'
              method="post">
        <x-form.input name="scheduled_at"
                      type="date"
                      label="Date"
                      min="{{ $season->start_date }}"
                      required />
        <x-form.input name="time"
                      type="time"
                      label="Time"
                      min="08:00"
                      required />
        @for ($i = 0; $i < $season->variant->max_number_of_teams; $i++)
          <x-form.select name="teams[]"
                         label="Team {{ $i + 1 }}"
                         :options="$season->teams"
                         required />
        @endfor
      </x-form>
    </x-modal>
  @endpush
</x-layouts.coordinator>
