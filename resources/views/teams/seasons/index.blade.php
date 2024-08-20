{{--
file: resources/views/teams/seasons/index.blade.php
author: Ian Kollipara
date: 2024-08-12
description: The primary view for the seasons panel.
 --}}

<x-layouts.authed class="bg-cune-white"
                  title="IMS Teams | Active Seasons">
  @forelse ($seasons as $season)
    <div class="flex w-full flex-col items-center justify-between md:flex-row">
      <div class="text-center md:text-left">
        <h2 class="text-xl font-bold">{{ $season->name }}</h2>
        <p class="text-gray-600">
          {{ Str::limit($season->description, 25) }}
        </p>
      </div>
      <a class="btn"
         href="{{ route("seasons.show", $season) }}">View Season</a>
    </div>
  @empty
    <p class="text-center text-3xl">No active seasons found.</p>
  @endforelse
  {{ $seasons->links() }}
</x-layouts.authed>
