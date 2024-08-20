{{--
file: resources/views/profiles/edit.blade.php
author: Ian Kollipara
date: 2024-08-14
description: The view to edit a profile.
 --}}

@php
  use App\Enums\ClassStanding;
  use App\Enums\Gender;
@endphp

<x-layouts.authed title="IMS | Edit Profile"
                  page-title="Edit Profile">
  @fragment("form")
    <x-form route='{{ route("profile.update") }}'
            :model="$user"
            method="put">
      <x-form.input name="name"
                    label="Name" />
      <x-form.input name="email"
                    type="email"
                    help="Please use your Concordia email address."
                    label="Email" />
      <x-form.select name="class_standing"
                     label="Class Standing"
                     :options="enum_to_select(ClassStanding::class)" />
      <x-form.select name="gender"
                     label="Gender"
                     :options="enum_to_select(Gender::class)" />
    </x-form>
  @endfragment
  <div class="flex justify-end mt-5">
    <form action='{{ route("profile.destroy") }}'
          hx-confirm="Are You Sure? This is irreversible."
          method="post">
      @csrf
      @method("delete")
      <button class="py-2 px-3 rounded hover:text-cune-white text-gray-100 hover:bg-red-800 transition-colors font-cune-text disabled:opacity-80 bg-red-500"
              type="submit">
        Delete Account
      </button>
    </form>
  </div>
</x-layouts.authed>
