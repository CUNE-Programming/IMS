{{--
file: resources/views/components/layouts/app.blade.php
author: Ian Kollipara
date: 2024-07-20
description: The primary wrapper for all views in the application.
 --}}

@props(["title", "htmlClass" => [], "class" => []])

<!DOCTYPE html>
<html class="h-full w-full"
      lang="en"
      @class(explode_if_string($htmlClass))>

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  <meta name="htmx-config"
        content='{"globalViewTransitions":true, "defaultSwapStyle":"outerHTML"}'>
  @stack("meta")
  @routes
  @vite(["resources/css/app.css", "resources/js/app.js"])
  <title>{{ $title }}</title>
</head>

<body @class([
    "bg-cune-blue" => auth()->guest(),
    "bg-cune-white" => auth()->check(),
    "h-full",
])
      hx-boost="true"
      x-data
      {{ $attributes }}>
  <div @class(explode_if_string($class))>
    {{ $slot }}
  </div>

  <div class="absolute right-0 top-0 z-50 m-5"
       id="toast-container">
    @stack("toast")
    @session("success")
      <div class="fade-in rounded bg-green-700 px-3 py-2 text-cune-white shadow">
        <div class="flex flex-row-reverse">
          <x-tabler-x class="cursor-pointer hover:text-white"
                      onclick="
              this.parentElement.parentElement.classList.remove('fade-in');
              this.parentElement.parentElement.classList.add('fade-out');
              setTimeout(() => this.parentElement.parentElement.remove(), 500);
             "></x-tabler-x>
          <p class="flex-1 font-cune-sub">Success</p>
        </div>
        <p class="font-cune-text">{{ $value }}</p>
      </div>
    @endsession
    @session("error")
      <div class="fade-in rounded bg-red-700 px-3 py-2 text-cune-white shadow">
        <div class="flex flex-row-reverse">
          <x-tabler-x class="cursor-pointer hover:text-white"
                      onclick="
              this.parentElement.parentElement.classList.remove('fade-in');
              this.parentElement.parentElement.classList.add('fade-out');
              setTimeout(() => this.parentElement.parentElement.remove(), 500);
             "></x-tabler-x>
          <p class="flex-1 font-cune-sub">Error</p>
        </div>
        <p class="font-cune-text">{{ $value }}</p>
      </div>
    @endsession
  </div>
  <div class="modal-container"
       x-data="{ show: false }"
       x-on:show-modal.window="show = true"
       x-on:close="show = false"
       x-show="show"
       x-cloak
       x-on:click.self="show = false">
    @stack("modals")
  </div>
</body>

</html>
