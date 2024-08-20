{{--
file: resources/views/teams/seasons/teams/show.blade.php
author: Ian Kollipara
date: 2024-08-12
description: The primary view for the teams panel.
 --}}

<x-layouts.authed class="bg-cune-white"
                  title="IMS Teams | {!! $team->name !!}">
  <div class="flex w-full items-center justify-between">
    <h1 class="text-3xl">Manage Team</h1>
    <button class="btn"
            data-action="modals#showModal"
            data-modals-modal-id-param="ContactCoordinatorModal"
            type="button">
      Contact Coordinator
    </button>
  </div>
  <main class="grid grid-cols-1 gap-6 md:grid-cols-[0.33fr_1fr]">
    <section>
      <div class="flex w-full items-center justify-between">
        <h2 class="text-xl">Roster</h2>
        <button class="text-gray-300 hover:text-gray-600"
                data-action="modals#showModal"
                data-modals-modal-id-param="AddNewPlayerModal"
                type="button"
                title="Add New Player">
          <i data-lucide="plus"></i>
        </button>
      </div>
      @forelse ($team->players as $player)
        @dump($player)
      @empty
        <p>No players found.</p>
      @endforelse
    </section>
    <section data-controller="calendar"
             data-calendar-left-header-value=""
             data-calendar-center-header-value=""
             data-calendar-right-header-value="title"
             data-calendar-height-value="70vh"
             data-calendar-feed-url-value="">
      <div data-calendar-target="calendar"></div>
    </section>
  </main>
  @push("modals")
    <x-modal title="Add New Player"
             modal-id="AddNewPlayerModal">
    </x-modal>
    <x-modal title="Contact Coordinator"
             modal-id="ContactCoordinatorModal">
      <x-form route=""
              method="post">
        <x-form.input name="subject"
                      label="Subject"
                      required />
        <x-form.textarea name="message"
                         label="Message"
                         required />
      </x-form>
    </x-modal>
  @endpush
</x-layouts.authed>
