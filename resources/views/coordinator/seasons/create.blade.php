{{--
file: resources/views/coordinator/seasons/create.blade.php
author: Ian Kollipara
date: 2024-08-11
description: The create page for a season in the coordinator panel.
--}}

<x-layouts.coordinator title="IMS Coordinator | Seasons">
  <h1 class="text-2xl font-semibold">Create Season</h1>
  <x-form route='{{ route("coordinator.seasons.store") }}'
          method="post">
    <x-form.select name="variant_id"
                   :options='$variants->pluck("name", "id")'
                   label="Variant" />
    <x-form.input name="registration_start"
                  type="date"
                  label="Registration Start Date" />
    <x-form.input name="registration_end"
                  type="date"
                  label="Registration End Date" />
    <x-form.input name="start_date"
                  type="date"
                  label="Start Date" />
    <x-form.input name="end_date"
                  type="date"
                  label="End Date" />
    <x-form.textarea name="description"
                     label="Description" />
  </x-form>
</x-layouts.coordinator>
