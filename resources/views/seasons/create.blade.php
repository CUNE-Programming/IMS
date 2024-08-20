{{--
file: resources/views/seasons/create.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The view to create a season.
 --}}

<x-layouts.authed title="IMS | Create a Season"
                  page-title="Create Season">
  @fragment("form")
    <x-form x-data="{ reg_start: '', reg_end: '', start: '', end: '' }"
            route='{{ route("seasons.store") }}'
            method="post">
      <x-form.select name="season[variant_id]"
                     :options='$variants->pluck("name", "id")'
                     label="Sport" />
      <x-form.input name="season[registration_start]"
                    type="date"
                    x-model="reg_start"
                    label="Registration Start Date" />
      <x-form.input name="season[registration_end]"
                    type="date"
                    x-model="reg_end"
                    x-bind:min="reg_start"
                    label="Registration End Date" />
      <x-form.input name="season[start_date]"
                    type="date"
                    x-model="start"
                    x-bind:min="reg_end"
                    label="Start Date" />
      <x-form.input name="season[end_date]"
                    type="date"
                    x-model="end"
                    x-bind:min="start"
                    label="End Date" />
      <x-form.textarea name="season[description]"
                       rich
                       label="Description" />
    </x-form>
  @endfragment
</x-layouts.authed>
