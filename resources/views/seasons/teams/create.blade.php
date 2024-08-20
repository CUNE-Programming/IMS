{{--
file: resources/views/seasons/teams/create.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The view to create a team for a season.
 --}}

<x-layouts.authed title="IMS | Create a Team"
                  page-title="Create Team for {!! $season->name !!}"
                  :currentSeason="$season">
  @fragment("form")
    <div class="mb-3 flex">
      <a class="btn flex gap-x-3 items-center"
         href="{{ route("seasons.index") }}">
        <x-tabler-arrow-left class="h-4 w-4" />
        Back
      </a>
    </div>
    <x-form x-data=""
            route='{{ route("seasons.teams.store", $season) }}'
            method="post">
      <x-form.input name="team[name]"
                    label="Team Name"
                    help="Enter the name for your team. Please choose something appropriate. Your name will need to be approved before your team is official." />
      <x-form.select name="players"
                     label="Players"
                     multiple
                     help="Select the players for your team. If the player does exist, they will be shown in the search results. If they do not exist, you can add them by entering their email address."
                     config="{
                        settings: {
                            maxSelected: {{ $season->max_team_size - 1 }},
                            hideSelected: true,
                            placeholderText: 'Search Player Emails...',
                        },
                        events: {
                            addable: function (value) {

                                if (value.includes('@') && (value.includes('cune.org') || value.includes('cune.edu'))) {
                                    return value;
                                }
                                return false;

                            },
                            search: (search, currentData) =>  new Promise((resolve, reject) => {
                                const debounce = (fn, delay) => {
                                    let timeout;
                                    return (...args) => {
                                        clearTimeout(timeout);
                                        timeout = setTimeout(() => fn(...args), delay);
                                    };
                                };
                                debounce(() =>
                                    axios.get(route('api.players'), {
                                        params: { email: search }
                                    }).then(({ data }) => resolve(data)),
                                300)();

                            }),
                        },
                     }" />
    </x-form>
  @endfragment
</x-layouts.authed>
