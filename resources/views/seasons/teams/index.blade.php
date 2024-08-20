{{--
file: resources/views/seasons/teams/index.blade.php
author: Ian Kollipara
date: 2024-08-19
description: The view to show all teams in a season.
 --}}

<x-layouts.authed :title='"IMS | " . $season->name'
                  :current-season="$season"
                  page-title="{!! $season->name !!} Teams">
  <div class="flex flex-col">
    <h2 class="text-2xl font-semibold">Teams</h2>
    <p>
      Here are all the teams in the {{ $season->name }} season.
      You may approve or deny any pending teams.
    </p>
    <ul class="mt-2 w-full">
      @foreach ($season->teams as $team)
        <li class="border-b-2 border-gray-300 w-full px-2.5 py-3 flex justify-between items-center">
          <h2>{{ $team->name }}</h2>
          @if ($team->status->value === "Pending")
            <div class="flex gap-x-3">
              <form action="{{ route("seasons.teams.approve", [$season, $team]) }}"
                    method="post">
                @csrf
                <button class="btn"
                        type="submit">Approve</button>
              </form>
              <form action="{{ route("seasons.teams.deny", [$season, $team]) }}"
                    method="post">
                @csrf
                <button class="btn"
                        type="submit">Deny</button>
              </form>
            </div>
        </li>
      @endif
      @endforeach
    </ul>
  </div>
</x-layouts.authed>
