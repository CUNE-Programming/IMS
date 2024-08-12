{{--
file: resources/views/coordinator/seasons/index.blade.php
author: Ian Kollipara
date: 2024-08-05
description: The index page for the seasons in the coordinator panel.
 --}}

<x-layouts.coordinator title="IMS Coordinator | Seasons">
  <h1 class="text-2xl font-semibold">Active Seasons</h1>
  @foreach ($seasons as $season)
    @include("coordinator.seasons._season-card", ["season" => $season])
  @endforeach
</x-layouts.coordinator>
