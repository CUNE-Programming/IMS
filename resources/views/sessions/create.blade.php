{{--
file: resources/views/sessions/create.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The login form.
 --}}

<x-layouts.guest class="h-full w-full grid grid-cols-1 md:grid-cols-[0.25fr_1fr] grid-rows-[auto_1fr]"
                 title="IMS | Login"
                 html-class="bg-cune-blue h-full"
                 navbar-class="col-span-2">
  <div class="my-auto flex h-full w-full flex-col gap-3 p-8 text-center border-x-4 ring-gray-300 md:bg-cune-white">
    <div class="mt-auto"><x-logo.large class="mx-auto w-64" /></div>
    <h1 class="font-cune-main text-lg text-gray-800 md:text-3xl">Login to IMS</h1>
    <form class="mb-auto"
          action="{{ route("sessions.store") }}"
          method="post">
      @csrf
      <div class="mb-3 flex flex-col">
        <label class="hidden text-left text-gray-600"
               for="login-form--email">Your Email</label>
        <input class="w-full rounded p-2 shadow-sm ring-1 ring-cune-blue/30 focus:ring-1 focus:ring-cune-blue"
               id="login-form--email"
               name="email"
               type="email"
               placeholder="Your Email...">
        <button class="pill-btn"
                type="submit">Login</button>
      </div>
    </form>
  </div>
  <div class="relative hidden h-full md:block">
    <img class="h-full object-cover"
         src="{{ Vite::asset("resources/images/Weller_Tall16x9.jpg") }}"
         alt="Picture of Weller Hall on Concordia University, Seward's Campus">
    <div class="absolute left-0 top-0 z-10 h-full w-full bg-cune-blue/50"></div>
  </div>
</x-layouts.guest>
