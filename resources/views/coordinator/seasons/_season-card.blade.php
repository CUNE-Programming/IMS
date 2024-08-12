{{--
file: resources/views/coordinator/seasons/_season-card.blade.php
author: Ian Kollipara
date: 2024-08-05
description: A card component for displaying a season in the coordinator panel.
 --}}

@props(["season"])

<div class="mb-3 w-full rounded px-3 py-2 outline outline-gray-300 last:mb-0">
  <div class="flex w-full justify-between">
    <h2>{{ $season->name }}</h2>
    <p class="italic text-gray-400"># of Teams: {{ $season->teams()->count() }}</p>
  </div>
  <div class="flex w-full items-center justify-between">
    <a class="btn"
       href="{{ route("coordinator.seasons.show", $season) }}">
      Manage
    </a>
    <table class="table-auto text-right">
      <tbody>
        <tr class="table-row w-full">
          <td class="border-r border-gray-300 pe-2">Registration</td>
          <td class="ps-2">{{ $season->registration_start->toFormattedDateString() }} -
            {{ $season->registration_end->toFormattedDateString() }}</td>
        </tr>
        <tr>
          <td class="border-r border-gray-300 pe-2">Season</td>
          <td class="ps-2">{{ $season->start_date->toFormattedDateString() }} -
            {{ $season->end_date->toFormattedDateString() }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
