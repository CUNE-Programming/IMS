{{--
file: resources/views/seasons/show.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The view to see a season.
 --}}

<x-layouts.authed title="IMS | {!! $season->name !!}"
                  :seasons="$seasons"
                  :current-season="$season"
                  page-title="{!! $season->name !!}">
  <div x-data="calendar({
      headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      events: {
          url: '{{ route("seasons.ical", $season) }}',
          format: 'ics',
      },
      eventClick: function(info) {
          console.log(info);
      },
  })"
       x-init="setTimeout(() => calendar.refetchEvents(), 5000)"></div>
</x-layouts.authed>
