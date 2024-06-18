{{--
file: resources/views/seasons/show.blade.php
author: Ian Kollipara & Aidan Nachi
date: 2024-06-11
description: This file contains the HTML for the seasons show page.
 --}}

 @php
    $title = "IMS - " . $season->name;
 @endphp

<x-layouts.app title="{{ $title }}">
    <header class="text-gray-50 bg-blue-500 p-5">
        <h1 class="text-5xl font-semibold tracking-wide mb-3">{{ $season->name }}</h1>
        <div class="inline-flex gap-4">
            <x-button.a>View {{ $season->sport->name }}</x-button.a>
            @if ($season->is_active)
                <x-button.a>Join Season</x-button.a>
            @endif
        </div>
        <table>
            <thead>
                <tr>
                <th>Registration</th>
                <th>Season</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        {{ $season->registration_start->toFormattedDateString() }} ➨ {{ $season->registration_end->toFormattedDateString() }}
                    </td>
                    <td>
                        {{ $season->start_date->toFormattedDateString() }} ➨ {{ $season->end_date->toFormattedDateString() }}
                    </td>
                </tr>
            </tbody>
        </table>
        <p>
        </p>
    </header>

</x-layouts.app>
