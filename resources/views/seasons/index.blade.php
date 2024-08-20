{{--
file: resources/views/seasons/index.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The view to see all active seasons.
 --}}

<x-layouts.authed title="IMS | Active Seasons"
                  page-title="Currently Active Seasons"
                  :seasons="$seasons">
  @forelse ($seasons as $season)
    @unless (auth()->user()->isFreeAgentIn($season) or
            auth()->user()->isCoordinator($season) or
            auth()->user()->isPlayerIn($season))
      <button class="flex outline outline-gray-300 rounded w-full hover:text-gray-100 hover:bg-cune-blue mb-3"
              type="button"
              x-on:click="$dispatch('show-modal', 'JoinSeasonModal'); $dispatch('modal-info', {
                name: @js($season->name),
                description: @js($season->description),
                id: @js($season->id),
            })">
        <div class="flex flex-col p-4 items-start">
          <img class="w-24 h-24 object-cover rounded-full"
               src="{{ $season->variant->sport->image }}"
               alt="{{ $season->name }}">
        </div>
        <div class="flex flex-col p-4 items-start">
          <h3 class="text-lg font-semibold">{{ $season->name }}</h3>
          <p class="text-sm">{{ str($season->description)->stripTags()->limit(20) }}</p>
          <p class="text-sm">
            <span class="font-bold">Registration</span>:
            {{ $season->registration_start->format("M d, Y") }} -
            {{ $season->registration_end->format("M d, Y") }}
          </p>
          <p class="text-sm">
            <span class="font-bold">Season</span>:
            {{ $season->start_date->format("M d, Y") }}
            - {{ $season->end_date->format("M d, Y") }}
          </p>
        </div>
      </button>
    @endunless
  @empty
    <p>No Seasons...</p>
  @endforelse
  @push("modals")
    <x-modal title="Join Season"
             modal-id="JoinSeasonModal">
      <div class="flex flex-col gap-6"
           x-data="{ name: '', description: '', id: null }"
           x-on:modal-info.window="name=$event.detail.name; description=$event.detail.description; id = $event.detail.id">
        <h2 class="text-xl md:text-3xl"
            x-text="name"></h2>
        <p x-html="description"></p>
        <a class="btn mb-3 mt-3"
           x-bind:href="id ? route('seasons.teams.create', id) : ''"
           x-on:modal-info.window="$nextTick(() => htmx.process($el))">
          <h3>Join as a Team</h3>
          <p>
            A team is a group of players that will compete together in the season.
            If you and a group of friends are interested in playing together, this is the option for you.
          </p>
        </a>
        <form x-bind:action="id ? route('seasons.free-agents.store', id) : ''"
              x-on:modal-info.window="$nextTick(() => htmx.process($el))"
              method="post">
          @csrf
          <input name="user_id"
                 type="hidden"
                 value="{{ auth()->user()->id }}">
          <button class="btn text-left">
            <h3>Join as a Free Agent</h3>
            <p>
              If you are interested in playing but do not have a team, you can join as a free agent.
              A free agent is someone available to join a team that needs more players.
              If you happen to form a team, you can still join as a team, but this is a great way to get involved.
            </p>
          </button>
        </form>
      </div>
    </x-modal>
  @endpush
</x-layouts.authed>
