{{--
file: resources/views/components/layouts/app.blade.php
author: Ian Kollipara
date: 2024-07-20
description: The primary wrapper for all views in the application.
 --}}

@props(["title", "htmlClass" => []])

@php
  $htmlClass = is_string($htmlClass) ? explode(" ", $htmlClass) : $htmlClass;
@endphp

<!DOCTYPE html>
<html lang="en"
      @class($htmlClass)>

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
  @stack("meta")
  @vite(["resources/css/app.css", "resources/js/app.js"])
  <title>{{ $title }}</title>
</head>

<body data-controller="modals"
      {{ $attributes }}>
  {{ $slot }}

  <div class="absolute right-0 top-0 z-50 m-5"
       id="toast-container">
    @stack("toast")
    @session("success")
      <div class="fade-in rounded bg-green-700 px-3 py-2 text-cune-white shadow">
        <div class="flex flex-row-reverse">
          <i class="cursor-pointer hover:text-white"
             data-lucide="x"
             onclick="
              this.parentElement.parentElement.classList.remove('fade-in');
              this.parentElement.parentElement.classList.add('fade-out');
              setTimeout(() => this.parentElement.parentElement.remove(), 500);
             "></i>
          <p class="flex-1 font-cune-sub">Success</p>
        </div>
        <p class="font-cune-text">{{ $value }}</p>
      </div>
    @endsession
    @session("error")
      <div class="fade-in rounded bg-red-700 px-3 py-2 text-cune-white shadow">
        <div class="flex flex-row-reverse">
          <i data-lucide="x"></i>
          <p class="flex-1 font-cune-sub">Error</p>
        </div>
        <p class="font-cune-text">{{ $value }}</p>
      </div>
    @endsession
  </div>
  <div class="modal-container"
       data-show="false"
       data-modals-target="modalContainer"
       data-action="click->modals#closeAllModals">
    @stack("modals")
  </div>
</body>

</html>
