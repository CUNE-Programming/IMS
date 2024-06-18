{{--
file: resources/views/seasons/index.blade.php
author: Ian Kollipara & Aidan Nachi
date: 2024-06-06
description: This file contains the HTML for the seasons index page.
 --}}

<x-layouts.app title="IMS - Seasons">
    <main x-data="{sportName: ''}" class="flex flex-col">
        <header class="bg-blue-500 text-gray-50 p-5">
            <h1 class="text-5xl font-semibold tracking-wider">All Seasons</h1>
            <form  x-effect="console.log(sportName)" class="text-gray-800" action="{{ route('seasons.index') }}" method="get">
                <label for="sport" class="sr-only">Search</label>
                <select x-model="sportName" name="sport">
                    <option value="">All Sports</option>
                    @foreach ($sports as $sport)
                        <option @if ($sport->name == request()->query('sport')) selected @endif value="{{ $sport->name }}">{{ $sport->name }}</option>
                    @endforeach
                </select>
            </form>
        </header>
        <section class="p-5 pb-0">
            <table class="w-full text-left">
                <thead class="border-b border-gray-800">
                    <tr>
                    <th>Season</th>
                    <th>Dates</th>
                    <th aria-label="links"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seasons as $season)
                        <tr x-bind:class="{'border-b border-gray-300 last:border-b-0': true, 'hidden': sportName && sportName !== '{{ $season->sport->name }}'}">
                            <td class="font-bold">{{ $season->name }}</td>
                            <td>
                                {{ $season->start_date->toFormattedDateString() }} ➨ {{ $season->end_date->toFormattedDateString() }}
                            </td>
                            <td>
                                <a class="hover:border-b hover:border-blue-800" href="{{ route("seasons.show", $season) }}">Go To...</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</x-layouts.app>
