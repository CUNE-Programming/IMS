{{--
file: resources/views/seasons/games/create.blade.php
author: Ian Kollipara
date: 2024-08-20
description: The view to create a game in a season.
 --}}

<x-layouts.authed :title='"IMS | " . $season->name . " | Add Game"'
                  :current-season="$season"
                  page-title="{!! $season->name !!} | Add Game">
  <x-form route='{{ route("seasons.games.store", $season) }}'
          method="post">
    <x-form.input name="scheduled_date"
                  type="date"
                  label="Schedule Date"
                  help="What day should the game be played"
                  min="{{ $season->start_date->toDateString() }}"
                  max="{{ $season->end_date->toDateString() }}" />
    <x-form.input name="scheduled_time"
                  type="time"
                  label="Schedule Time"
                  help="What time should the game be played" />
    <x-form.select name="teams"
                   label="Teams"
                   help="Which teams are playing in this game"
                   :options='$season->teams()->pluck("name", "id")'
                   multiple
                   config="{
                        settings: {
                            maxSelected: {{ $season->variant->max_number_of_teams }},
                            hideSelected: true,
                        },
                   }" />
  </x-form>
</x-layouts.authed>
