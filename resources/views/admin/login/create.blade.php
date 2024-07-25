{{--
file: resources/views/admin/login/create.blade.php
author: Ian Kollipara
date: 2024-07-20
description: The login form for the admin panel.
 --}}

<x-layouts.app class="h-full w-full md:grid md:grid-cols-[0.33fr_1fr]"
               title="IMS Admin | Login"
               html-class="bg-cune-blue h-full">
  <div class="my-auto flex h-full w-full flex-col gap-3 p-8 text-center shadow-xl ring-4 ring-gray-300 md:bg-cune-white">
    <div class="mt-auto"><x-logo.large class="mx-auto w-64" /></div>
    <h1 class="font-cune-main text-lg text-gray-800 md:text-3xl">Login to IMS Admin</h1>
    @fragment("admin.login-form")
      <form action="{{ route("admin.login.store") }}"
            method="post">
        @csrf
        <div class="mb-3 flex flex-col">
          <label class="hidden text-left text-gray-600"
                 for="login-form--email">Your Admin Email</label>
          <input class="w-full rounded p-2 shadow-sm ring-1 ring-cune-blue/30 focus:ring-1 focus:ring-cune-blue"
                 id="login-form--email"
                 name="email"
                 type="email"
                 placeholder="Your Admin Email...">
          <button class="pill-btn"
                  type="submit">Login</button>
        </div>
      </form>
      <div class="mb-auto flex justify-around">
        <a class="underline decoration-cune-blue hover:decoration-cune-wheat"
           href="">Go to Team Login</a>
        <a class="underline decoration-cune-blue hover:decoration-cune-wheat"
           href="">Go to Coordinator Login</a>
      </div>
    @endfragment
  </div>
  <div class="relative hidden h-full md:block">
    <img class="h-full object-cover"
         src="{{ Vite::asset("resources/images/Weller_Tall16x9.jpg") }}"
         alt="Picture of Weller Hall on Concordia University, Seward's Campus">
    <div class="absolute left-0 top-0 z-10 h-full w-full bg-cune-blue/50"></div>
  </div>
</x-layouts.app>
