{{--
file: resources/views/public/contact-us/create.blade.php
author: Ian Kollipara
date: 2024-08-12
description: The primary view for the contact us panel.
 --}}

<x-layouts.guest class="bg-cune-white">
  <header class="bg-white shadow">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900">Contact Us</h1>
    </div>
  </header>
  <main class="bg-cune-white">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
      <x-form route='{{ route("contact-us.store") }}'
              method="post">
        <x-form.input name="email"
                      type="email"
                      label="Email" />
        <x-form.textarea name="message"
                         label="Message" />
        </x-form.button>
    </div>
  </main>
</x-layouts.guest>
