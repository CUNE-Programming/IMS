{{--
file: resources/views/seasons/games/index.blade.php
author: Ian Kollipara
date: 2024-08-20
description: The view to show games in a season.
 --}}

<x-layouts.authed :title='"IMS | " . $season->name'
                  :currentSeason="$season"
                  page-title="{!! $season->name !!}">
  <div class="flex flex-col md:space-y-3">
    <div class="w-full">
      <div class="flex w-full justify-between items-center">
        <h2 class="text-2xl font-semibold">Games</h2>
        <a class="btn"
           href="{{ route("seasons.games.create", $season) }}">Add New Game</a>
      </div>
      <ul class="mt-2">
        @foreach ($games as $game)
          <li class="flex w-full justify-between items-center border-b-2 border-gray-300 px-2.5 py-3">
            <h2 @class(["line-through" => $game->status->isCancelled()])>{{ $game->scheduled_at->toFormattedDateString() }} -
              {{ $game->teams->pluck("name")->join(" vs ") }}
            </h2>
            <div class="flex gap-x-3">
              @unless ($game->status->isCancelled())
                <a class="btn"
                   href="{{ route("seasons.games.edit", [$season, $game]) }}">Edit</a>
                <button class="btn"
                        type="button"
                        x-on:click="$dispatch('show-modal', 'PostponeGameModel{{ $game->id }}')">Postpone</button>
                <form action="{{ route("seasons.games.destroy", [$season, $game]) }}"
                      method="post">
                  @csrf
                  @method("delete")
                  <button class="btn"
                          type="submit">Cancel</button>
                </form>
              @endunless
            </div>
          </li>
          @push("modals")
            <x-modal title="Postpone Game"
                     modal-id="PostponeGameModel{{ $game->id }}">
              <x-form route='{{ route("seasons.games.postpone", [$season, $game]) }}'
                      method="post">
                <x-form.input name="postpone_date"
                              type="date"
                              label="Schedule Date"
                              help="What day should the game be played"
                              min="{{ $game->scheduled_at->toDateString() }}"
                              max="{{ $season->end_date->toDateString() }}" />
                <x-form.input name="postpone_time"
                              type="time"
                              label="Schedule Time"
                              help="What time should the game be played" />
              </x-form>
            </x-modal>
          @endpush
        @endforeach
      </ul>
      {{ $games->links() }}
    </div>
  </div>
</x-layouts.authed>
