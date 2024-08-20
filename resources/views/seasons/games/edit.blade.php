{{--
file: resources/views/seasons/games/edit.blade.php
author: Ian Kollipara
date: 2024-08-20
description: The view to edit a game in a season.
 --}}

<x-layouts.authed :title='"IMS | " . $season->name . " | Edit Game"'
                  :current-season="$season"
                  page-title="{!! $season->name !!} | Edit Game">
  <p class="mb-3">
    This form will allow you to edit the game. You can change the date and time of the game, as well as the scores of
    the teams.
    If you choose to postpone the game, you can do so by selecting a new date and time for the game.
    If you choose to set the scores, you can do so by entering the scores for each team.
    You may not postpone and set scores at the same time.
  </p>
  <x-form route='{{ route("seasons.games.update", [$season, $game]) }}'
          :model="$game"
          method="patch">
    @foreach ($game->teams as $team)
      <x-form.input class="hidden"
                    name="teams[{{ $loop->index }}][id]"
                    label=""
                    readonly
                    :value="$team->id" />
      <x-form.input name="teams[{{ $loop->index }}][name]"
                    label="Team"
                    disabled
                    :value="$team->name" />
      <x-form.input name="teams[{{ $loop->index }}][score]"
                    type="number"
                    :value="$team->pivot->score"
                    label="Score" />
    @endforeach
  </x-form>
</x-layouts.authed>
