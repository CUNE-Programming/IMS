{{--
file: resources/views/components/modal.blade.php
author: Ian Kollipara
date: 2024-07-25
description: A modal component for displaying content in a modal.

The use of the noop method is to prevent the modal from closing when
the user clicks on the modal itself. This is useful when the modal
contains a form or other interactive elements that should not close
the modal when clicked.
 --}}

@props(["title", "modalId"])

<div data-show="false"
     data-modal-id="{{ $modalId }}"
     data-action="click->modals#noop:stop"
     data-modals-target="modal"
     {{ $attributes->class(["flex-col", "rounded", "bg-cune-white", "px-4", "py-3", "shadow-md", "ring-1", "ring-cune-blue", "data-[show=false]:hidden", "data-[show=true]:flex", "col-start-2", "row-start-2", "m-auto", "min-w-[50%]", "max-w-[80%]", "z-100"]) }}>
  <div class="flex items-center justify-between">
    <h3 class="text-2xl">{{ $title }}</h3>
    <i class="cursor-pointer transition-colors hover:stroke-gray-700"
       data-action="click->modals#hideModal"
       data-modals-modal-id-param="{{ $modalId }}"
       data-lucide="x"></i>
  </div>
  {{ $slot }}
</div>
