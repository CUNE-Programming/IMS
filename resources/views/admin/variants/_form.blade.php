{{--
file: resources/views/admin/variants/_form.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The form for editing variants in the admin panel.
 --}}

<x-form :route="$route"
        :method="$method"
        submit-text="{{ $btnText }}"
        :model="$variant">
  <div class="grid grid-cols-[1fr_0.25fr] gap-3">
    <div class="flex h-full flex-col">
      <h2 class="text-xl">Details</h2>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--sport_id">Sport</label>
        <select id="admin-variants--sport_id"
                name="sport_id"
                @if ($variant->exists) disabled @endif>
          @unless ($variant->exists)
            @foreach ($sports as $sport)
              <option value="{{ $sport->id }}">{{ $sport->name }}</option>
            @endforeach
          @else
            <option value="{{ $variant->sport->id }}"
                    selected>{{ $variant->sport->name }}</option>
          @endunless
        </select>
      </div>
      <x-form.input name="name" />
      <x-form.textarea class="flex-1"
                       name="description"
                       wrapper-class="flex flex-col flex-1" />
    </div>
    <div>
      <x-form.input name="max_number_of_teams"
                    type="number"
                    label="Max # of Teams"
                    min="2" />
      <x-form.input name="average_duration"
                    type="number"
                    label="Average Duration"
                    min="0" />
      <x-form.input name="max_team_size"
                    type="number"
                    label="Max Team Size"
                    min="1" />
      <x-form.input name="min_boys"
                    type="number"
                    label="Min # of Boys"
                    min="1" />
      <x-form.input name="min_girls"
                    type="number"
                    label="Min # of Girls"
                    min="1" />
    </div>
  </div>
</x-form>

{{-- <form class="flex flex-col gap-1"
      action="{{ $route }}"
      method="post">
  @csrf
  @method($method)
  <div class="flex w-full justify-between">
    <h1 class="text-3xl">{{ $formTitle }}</h1>
    <div class="flex gap-2">
      <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
         href="{{ route("admin.variants.index") }}">
        <i class="size-4"
           data-lucide="arrow-left"></i>
        Go Back
      </a>
      <button class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
              type="submit">
        {{ $btnText }}
      </button>
    </div>
  </div>
  <div class="grid grid-cols-[1fr_0.25fr] gap-3">
    <div class="flex h-full flex-col gap-3">
      <h2 class="text-xl">Details</h2>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--sport_id">Sport</label>
        <select id="admin-variants--sport_id"
                name="sport_id"
                @if ($variant->exists) disabled @endif>
          @unless ($variant->exists)
            @foreach ($sports as $sport)
              <option value="{{ $sport->id }}">{{ $sport->name }}</option>
            @endforeach
          @else
            <option value="{{ $variant->sport->id }}"
                    selected>{{ $variant->sport->name }}</option>
          @endunless
        </select>
      </div>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--name">Name</label>
        <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
               id="admin-variants--name"
               name="name"
               type="text"
               value="{{ old("name", $variant) }}">
      </div>
      <div class="flex flex-1 flex-col">
        <label class="font-cune-sub"
               for="admin-variants--description">Description</label>
        <textarea class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
                  id="admin-variants--description"
                  name="description"
                  type="text">
                    {{ old("description", $variant) }}
                    </textarea>
      </div>
    </div>
    <div>
      <h2 class="text-xl">Requirements</h2>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--max_number_of_teams">Max # of Teams</label>
        <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
               id="admin-variants--max_number_of_teams"
               name="max_number_of_teams"
               type="number"
               value="{{ old("max_number_of_teams", $variant) }}"
               min="{{ $variant->max_number_of_teams ?? 2 }}">
      </div>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--average_duration">Average Length (min.)</label>
        <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
               id="admin-variants--average_duration"
               name="average_duration"
               type="number"
               value="{{ old("average_duration", $variant) }}"
               min="0">
      </div>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--max_team_size">Max Team Size</label>
        <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
               id="admin-variants--max_team_size"
               name="max_team_size"
               type="number"
               value="{{ old("max_team_size", $variant) }}"
               min="{{ $variant->max_team_size ?? 1 }}">
      </div>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--min_girls">Min. # of Girls</label>
        <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
               id="admin-variants--min_girls"
               name="min_girls"
               type="number"
               value="{{ old("min_girls", $variant) }}"
               min="0">
      </div>
      <div class="flex flex-col">
        <label class="font-cune-sub"
               for="admin-variants--min_boys">Min. # of Boys</label>
        <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
               id="admin-variants--min_boys"
               name="min_boys"
               type="number"
               value="{{ old("min_boys", $variant) }}"
               min="0">
      </div>
    </div>
  </div>
</form> --}}
