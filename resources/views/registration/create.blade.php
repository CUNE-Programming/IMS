{{--
file: resources/views/registration/create.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The sign up form for new users.
 --}}

@php
  use App\Models\User;
@endphp

<x-layouts.guest class="h-full bg-cune-white">
  <x-layouts.header text="Sign Up" />
  <main class="md:max-w-[80ch] lg:max-w-[120ch] md:mx-auto mx-5 mt-5">
    <p>
      Please fill out the form below to sign up for the Concordia Intramural Management System.
      Once signed up, you can join a season and participate in intramural sports.
    </p>
    @include("registration._form", ["url" => route("registration.store"), "user" => new User()])
  </main>
</x-layouts.guest>
