{{--
file: resources/views/components/layouts/authed.blade.php
author: Ian Kollipara
date: 2024-08-12
description: The primary layout for authenticated users.
 --}}

@props(["title", "htmlClass" => ["bg-cune-white"], "currentSeason" => null, "seasons" => null])

@php
  use App\Models\Season;
  $seasons = $seasons ?? Season::whereActive()->withCoordinatorStatus(auth()->user())->with("variant")->get();
  $isCaptain = auth()->user()->isCaptainIn($currentSeason);
  $isPlayer = auth()->user()->isPlayerIn($currentSeason);
  $isFreeAgent = auth()->user()->isFreeAgentIn($currentSeason);
  if ($isCaptain or $isPlayer) {
      $currentTeam = auth()->user()->getTeamForSeason($currentSeason);
  }
@endphp

<x-layouts.app class="bg-cune-white"
               :title="$title"
               :htmlClass="$htmlClass"
               {{ $attributes }}>
  <div class="absolute w-full h-full top-0 left-0 bottom-0 lg:fixed lg:z-50 lg:flex lg:w-[18rem] lg:flex-col"
       id="app"
       x-cloak
       x-data="{ show: false, width: window.innerWidth, isMobile: window.innerWidth < 1024 }"
       x-show="show"
       x-resize.document="show = $width >= 1024; width = $width; isMobile = $width < 1024"
       x-on:menu-open.window="show = true"
       x-on:click.outside="if(width < 1024) { show = false }">
    <div class="flex grow flex-col gap-5 overflow-y-auto bg-cune-blue px-5 pb-4 h-full">
      <div class="flex h-16 flex-shrink-0 items-center"><x-logo.icon class="h-8 w-auto" /></div>
      <nav class="flex flex-1 flex-col">
        <ul class="flex flex-1 flex-col gap-7"
            role="list">
          <li>
            <ul class="-m-2 space-y-1"
                role="list"
                x-data="{ selectedSeason: @js($currentSeason?->id) }"
                x-effect="if(selectedSeason !== @js($currentSeason?->id)) { htmx.ajax('GET', route('seasons.show', selectedSeason), 'body') }">
              <select @class([
                  "text-gray-300",
                  "outline-none",
                  "ring-0",
                  "border-0",
                  "flex",
                  "text-nowrap",
                  "bg-transparent",
                  "gap-3",
                  "rounded-md",
                  "p-2",
                  "text-sm",
                  "font-semibold",
                  "w-full",
                  "leading-6",
                  "hover:bg-gray-700",
                  "hover:text-cune-white",
              ])
                      x-model="selectedSeason">
                <option value="">Join a Season</option>
                @foreach ($seasons as $season)
                  @if (
                      $isPlayer or
                          $isCaptain or
                          $isFreeAgent or
                          (isset($season->is_coordinator)
                              ? $season->is_coordinator
                              : auth()->user()->isCoordinator(variant: $season->variant)))
                    <option value="{{ $season->id }}"
                            @if ($season->id == $currentSeason?->id) selected @endif>
                      {{ $season->name }}
                    </option>
                  @endif
                @endforeach
              </select>
            </ul>
            <x-nav.item icon="calendar"
                        route="seasons.index">
              Join a Season
            </x-nav.item>
            @isset($currentSeason)
              <x-nav.item icon="calendar"
                          route="seasons.show"
                          :route-params='$currentSeason'>
                {!! $currentSeason->name !!}
              </x-nav.item>
            @endisset
          </li>
          @coordinator
            <li>
              <div class="text-xs font-semibold leading-6 text-gray-300">Coordinator</div>
              <ul class="-mx-2 mt-2"
                  role="list">
                <x-nav.item icon="star"
                            route="seasons.create">
                  Start New Season
                </x-nav.item>
                @if ($currentSeason and auth()->user()->isCoordinator(season: $currentSeason))
                  <x-nav.item icon="ball-basketball"
                              route="seasons.games.index"
                              :route-params='$currentSeason'>
                    Manage Games
                  </x-nav.item>
                  <x-nav.item icon="users"
                              route="seasons.teams.index"
                              :route-params='$currentSeason'>
                    Manage Teams
                  </x-nav.item>
                @endif
              </ul>
            </li>
          @endcoordinator
          @isset($currentSeason)
            @if ($isFreeAgent)
              <li>
                <div class="text-xs font-semibold leading-6 text-gray-300">Free Agent</div>
                <ul class="-mx-2 mt-2"
                    role="list">
                  <x-nav.item icon="users"
                              route="seasons.teams.create"
                              :route-params='[$currentSeason]'>
                    Form Team
                  </x-nav.item>
                </ul>
              </li>
              <li>
            @endif
            @if ($isPlayer or $isCaptain)
              <li>
                <div class="text-xs font-semibold leading-6 text-gray-300">
                  Player - @if ($currentTeam)
                    {!! $currentTeam->name !!}
                  @endif
                  @if ($currentTeam->status->value === "Pending")
                    <span class="text-xs ml-3 font-semibold leading-6 text-red-500">Pending</span>
                  @endif
                </div>
                <ul class="-mx-2 mt-2"
                    role="list">
                  <x-nav.item icon="calendar"
                              route="seasons.ical"
                              :route-params='$currentSeason'>
                    Get Calendar Feed
                  </x-nav.item>
                </ul>
              </li>
              <li>
            @endif
            @if ($isCaptain)
              <li>
                <div class="text-xs font-semibold leading-6 text-gray-300">
                  Captain - @if ($currentTeam)
                    {!! $currentTeam->name !!}
                  @endif
                  @if ($currentTeam->status->value === "Pending")
                    <span class="text-xs ml-3 font-semibold leading-6 text-red-500">Pending</span>
                  @endif
                </div>
                <ul class="-mx-2 mt-2"
                    role="list">
                  <x-nav.item icon="users"
                              route="seasons.teams.show"
                              :route-params='[$currentSeason, $currentTeam]'>
                    Manage Team
                  </x-nav.item>
                  {{-- @unless ($currentTeam->status->value === "Pending")
                    <x-nav.item icon="plus"
                                route="index">
                      Add Free Agent
                    </x-nav.item>
                  @endunless --}}
                </ul>
              </li>
              <li>
            @endif
          @endisset
          <div class="text-xs font-semibold leading-6 text-gray-300"></div>
          <ul class="-mx-2 mt-2"
              role="list">
          </ul>
          </li>
          <li>
            <div class="text-xs font-semibold leading-6 text-gray-300"></div>
            <ul class="-mx-2 mt-2"
                role="list">
            </ul>
          </li>
          <li class="mt-auto">
            <hr class="mb-3">
            <div class="flex items-center gap-4 lg:gap-6">
              <div class="relative"
                   x-data="{ show: false }">
                <button class="-m-1.5 flex items-center p-1.5 gap-6 text-white"
                        type="button"
                        x-on:click="show = !show">
                  <span class="sr-only">Open User Menu</span>
                  <img class="size-8 rounded-full bg-gray-300"
                       src="{{ auth()->user()->avatar }}"
                       alt="{{ auth()->user()->name }}">
                  <p>{{ auth()->user()->name }}</p>
                </button>
                <div class="absolute text-black z-10 mt-2 w-48 origin-bottom -translate-y-[150%] rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                     role="menu"
                     aria-orientation="vertical"
                     aria-labelledby="user-menu-button"
                     tabindex="-1"
                     x-cloak
                     x-on:click.outside="show = false"
                     x-transition:enter="fade-in"
                     x-transition:leave="fade-out"
                     x-show="show">
                  <!-- Active: "bg-gray-100", Not Active: "" -->
                  <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                     id="user-menu-item-0"
                     href="https://gravatar.com/profile"
                     role="menuitem"
                     tabindex="-1"
                     x-on:click="show = false">Your Profile</a>
                  <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                     id="user-menu-item-1"
                     href="{{ route("profile.edit") }}"
                     role="menuitem"
                     tabindex="-1"
                     hx-push-url="true"
                     hx-boost="true"
                     x-on:click="show = false">Settings</a>
                  <form id="user-menu-item-2"
                        role="menuitem"
                        tabindex="-1"
                        action="{{ route("sessions.destroy") }}"
                        method="post">
                    @csrf
                    @method("delete")
                    <button class="w-full block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 text-left"
                            type="submit"
                            x-on:click="show = false">Sign Out</button>
                  </form>
                </div>
              </div>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <main class="bg-cune-white lg:pl-[18rem]"
        id="app">
    <header
            class="sticky top-0 z-40 flex h-16 flex-shrink-0 items-center gap-4 border-b border-gray-100 bg-cune-white px-4 shadow-sm sm:gap-5 sm:px-6 lg:px-8">
      <button class="-m-2.5 cursor-pointer px-2.5 lg:hidden"
              type="button"
              x-on:click="$dispatch('menu-open')">
        <span class="sr-only">Open Sidebar</span>
        <x-tabler-menu class="size-6"></x-tabler-menu>
      </button>
      <div class="h-6 w-[1px] bg-gray-300 lg:hidden"
           aria-hidden="true"></div>
      <div class="flex flex-1 gap-4 self-stretch lg:gap-6">
        @isset($pageTitle)
          <h1 class="my-auto text-xl md:text-3xl">{{ $pageTitle }}</h1>
        @endisset
      </div>
    </header>
    <section class="py-10">
      <div class="px-4 sm:px-6 lg:px-8">
        {{ $slot }}
      </div>
    </section>
  </main>
</x-layouts.app>
