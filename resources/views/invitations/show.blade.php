{{--
file: resources/views/invitations/show.blade.php
author: Ian Kollipara
date: 2024-08-19
description: The view to show an invitation.
 --}}

<x-layouts.guest class="h-full bg-cune-white">
  <x-layouts.header text="Invitation" />
  <main class="md:max-w-[80ch] lg:max-w-[120ch] md:mx-auto mx-5 mt-5">
    <p>
      You have been invited to join the Concordia Intramural Management System. Please fill out the form below to sign
      up.
    </p>
    @include("registration._form", [
        "url" => route("invitations.update", ["team" => $team]),
        "user" => $user,
    ])
  </main>
</x-layouts.guest>
