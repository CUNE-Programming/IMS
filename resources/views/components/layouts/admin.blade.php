{{--
file: resources/views/components/layouts/admin.blade.php
author: Ian Kollipara
date: 2024-07-20
description: The primary wrapper for all views in the admin panel.
 --}}

@props(["title", "htmlClass" => ["bg-cune-white"]])

<x-layouts.app :title="$title"
               :htmlClass="$htmlClass"
               {{ $attributes }}>
  <div class="hidden lg:fixed lg:bottom-0 lg:top-0 lg:z-50 lg:flex lg:w-[18rem] lg:flex-col"
       id="app">
    <div class="flex grow flex-col gap-5 overflow-y-auto bg-cune-blue px-5 pb-4">
      <div class="flex h-16 flex-shrink-0 items-center"><x-logo.icon class="h-8 w-auto" /></div>
      <nav class="flex flex-1 flex-col">
        <ul class="flex flex-1 flex-col gap-7"
            role="list">
          <li>
            <ul class="-m-2 space-y-1"
                role="list">
              <x-nav.item route="admin.coordinators.index"
                          icon="users">
                Coordinators
              </x-nav.item>
              <x-nav.item route="admin.sports.index"
                          icon="ball-basketball">
                Sports
              </x-nav.item>
              <x-nav.item route="admin.variants.index"
                          icon="star">
                Variants
              </x-nav.item>
            </ul>
          </li>
          <li class="mt-auto">
            <form class="flex w-full"
                  action="{{ route("admin.login.destroy") }}"
                  method="post">
              @csrf
              @method("DELETE")
              <button class="flex flex-1 gap-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-300 hover:bg-gray-700 hover:text-cune-white"
                      href="#">
                <x-tabler-logout class="size-5 flex-shrink-0"
                                 data-lucide="log-out"></x-tabler-logout>
                Logout
              </button>
            </form>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <main class="bg-cune-white lg:pl-[18rem]">
    <header
            class="sticky top-0 z-40 flex h-16 flex-shrink-0 items-center gap-4 border-b border-gray-100 bg-cune-white px-4 shadow-sm sm:gap-5 sm:px-6 lg:px-8">
      <button class="-m-2.5 cursor-pointer px-2.5 lg:hidden"
              type="button">
        <span class="sr-only">Open Sidebar</span>
        <i class="size-6"
           data-lucide="menu"></i>
      </button>
      <div class="h-6 w-[1px] bg-gray-300 lg:hidden"
           aria-hidden="true"></div>
      <div class="flex flex-1 gap-4 self-stretch lg:gap-6">
        <form class="relative flex flex-1 bg-cune-white"
              action="#"
              method="GET">
          <label class="sr-only"
                 for="admin-coordinator--search">Search</label>
          <i class="pointer-events-none absolute bottom-0 left-0 top-0 h-full w-5 text-gray-300"
             data-lucide="search"></i>
          <input class="block size-full border-0 bg-cune-white py-0 pl-8 pr-0 text-gray-800 ring-0 focus:ring-0 sm:text-sm"
                 id="admin-coordinator--search"
                 type="search">
        </form>
        <div class="flex items-center gap-4 lg:gap-6">
          <button class="-m-2.5 cursor-pointer p-2.5 hover:text-gray-500"
                  type="button">
            <span class="sr-only">View Notifications</span>
            <i class="size-6"
               data-lucide="bell"></i>
          </button>
          <div class="hidden lg:block lg:h-6 lg:w-[1px] lg:bg-gray-300"
               aria-hidden="true">
          </div>
          <div class="relative">
            <button class="-m-1.5 flex cursor-pointer items-center p-1.5"
                    type="button">
              <span class="sr-only">Open User Menu</span>
              <img class="size-8 rounded-full bg-gray-300"
                   src="{{ auth()->user()->avatar }}"
                   alt="{{ auth()->user()->name }}">
            </button>
          </div>
        </div>
      </div>
    </header>
    <section class="py-10">
      <div class="px-4 sm:px-6 lg:px-8">
        {{ $slot }}
      </div>
    </section>
  </main>
</x-layouts.app>
