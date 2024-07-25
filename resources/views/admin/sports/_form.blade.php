{{--
file: resources/views/admin/sports/_form.blade.php
author: Ian Kollipara
date: 2024-07-22
description: The form partial for the sports in the admin panel.
 --}}

<x-form route="{{ $route }}"
        enctype="multipart/form-data"
        :method="$method"
        submit-text="{{ $btnText }}"
        :model="$sport">
  <x-form.file name="image"
               accepts="image/*"
               label="Display Image" />
  <x-form.input name="name" />
  <x-form.textarea name="description" />
</x-form>

{{-- <form class="flex flex-col gap-3"
      action="{{ $route }}"
      enctype="multipart/form-data"
      method="post">
  @csrf
  @method($method)
  <div class="flex w-full justify-between">
    <h1 class="text-3xl">{{ $formTitle }}</h1>
    <a class="flex items-center gap-1 rounded-lg bg-cune-blue px-3 py-2 font-semibold text-cune-white hover:bg-gray-900"
       href="{{ route("admin.sports.index") }}">
      <i class="size-4"
         data-lucide="arrow-left"></i>
      Go Back
    </a>
  </div>
  <div class="flex flex-col gap-3">
    @session("error")
      <div
           class="mb-2 flex items-center justify-between rounded bg-cune-clay px-3 py-2 font-cune-text text-gray-100 shadow ring-1 ring-red-800">
        <p>{{ $value }}</p>
        <button class="rounded hover:bg-red-800"
                type="button">
          <i data-lucide="x"></i>
        </button>
      </div>
    @endsession
    <div class="flex flex-col"
         data-controller="form--file"
         data-form--file-file-value="{{ old("image", $sport->image) }}">
      <label class="font-cune-sub"
             for="admin-sports--image">Display Image</label>
      <input id="admin-sports--image"
             name="image"
             data-form--file-target="input"
             type="file"
             value="{{ old("image", $sport) }}">
    </div>
    <div class="flex flex-col">
      <label class="font-cune-sub"
             for="admin-sports--name">Name</label>
      <input class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
             id="admin-sports--name"
             name="name"
             type="text"
             value="{{ old("name", $sport) }}">
    </div>
    <div class="flex flex-col">
      <label class="font-cune-sub"
             for="admin-sports--description">Description</label>
      <textarea class="flex-1 rounded border-none font-cune-text focus:ring-cune-wheat"
                id="admin-sports--description"
                name="description">
            {{ old("description", $sport) }}
          </textarea>
    </div>
  </div>
  <button class="pill-btn"
          type="submit">{{ $btnText }}</button>
</form> --}}
