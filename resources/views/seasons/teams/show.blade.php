{{--
file: resources/views/seasons/teams/show.blade.php
author: Ian Kollipara
date: 2024-08-19
description: The view to show a team in a season.
 --}}

<x-layouts.authed :title='"IMS
                  | " . $team->name'
                  :current-season="$season"
                  page-title="{!! $team->name !!}">
  <div class="flex flex-col md:space-y-3">
    <div class="w-full">
      <h2 class="text-2xl font-semibold">Captain</h2>
      <p>{{ $team->teamCaptain->name }}</p>
    </div>
    <div class="w-full">
      <h2 class="text-2xl font-semibold">Players</h2>
      <ul class="mt-2">
        @foreach ($team->players as $player)
          <li>{{ $player->name }}</li>
        @endforeach
      </ul>
    </div>
  </div>
</x-layouts.authed>
