{{--
file: resources/views/index.blade.php
author: Ian Kollipara
date: 2024-08-12
description: The primary view for the guest panel.
 --}}

<x-layouts.guest class="h-full bg-cune-blue"
                 html-class="h-full">
  <div
       class="relative isolate h-screen overflow-x-clip overflow-y-scroll bg-gray-900 py-24 sm:py-32 lg:overflow-hidden lg:py-64">
    <img class="absolute inset-0 -z-10 h-full w-full object-cover opacity-10 md:object-center"
         src="{{ Vite::asset("resources/images/Weller_Tall16x9.jpg") }}"
         alt="CUNE Weller">
    <div class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl">
      <div class="aspect-[1097_/_845] w-[68.56525rem] bg-gradient-to-tr from-cune-blue to-gray-950 opacity-20"
           style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)">
      </div>
    </div>
    <div
         class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:-top-[28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu">
      <div class="aspect-[1097_/_845] w-[68.56525rem] bg-gradient-to-tr from-cune-blue to-gray-950 opacity-20"
           style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%);">
      </div>
    </div>
    <div class="mx-auto mt-auto max-w-7xl px-6 lg:px-8">
      <div class="mx-auto max-w-2xl lg:mx-0">
        <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">Concordia Intramural Management System</h2>
        <p class="mt-6 text-lg leading-8 text-gray-300">
          A tool build for the students, by the students, to manage and participate in intramural sports at Concordia
          University, Nebraska.
        </p>
        <div class="mt-6 flex gap-6 text-xl">
          <a class="rounded-lg bg-cune-wheat px-5 py-3 font-cune-sub text-cune-blue transition-colors hover:bg-cune-blue hover:text-cune-nimbus disabled:opacity-80"
             href="{{ route("registration.create") }}">Sign up</a>
          <a class="rounded-lg bg-cune-wheat px-5 py-3 font-cune-sub text-cune-blue transition-colors hover:bg-cune-blue hover:text-cune-nimbus disabled:opacity-80"
             href="{{ route("sessions.create") }}">Login</a>
        </div>
      </div>
      <div
           class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-6 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3 lg:gap-8">
        @include("_index-card", [
            "icon" => "trophy",
            "title" => "Intramural Sports",
            "description" => "Sign up for intramural sports, view schedules, and more.",
        ])
        @include("_index-card", [
            "icon" => "calendar",
            "title" => "Calendar",
            "description" => "View upcoming games and add them to your calendar.",
        ])
        @include("_index-card", [
            "icon" => "users",
            "title" => "Teams",
            "description" => "Create and manage teams for intramural sports.",
        ])
      </div>
    </div>
  </div>
  <footer class="bg-cune-blue">
    <div class="px-3 pt-8 xl:pb-3">
      <p class="text-xs leading-5 text-gray-400">
        © 2024 Concorida Competitive Programming and Software Development Team. All rights reserved.
      </p>
    </div>
  </footer>
</x-layouts.guest>
