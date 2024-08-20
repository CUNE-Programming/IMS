{{--
file: resources/views/registration/_form.blade.php
author: Ian Kollipara
date: 2024-08-19
description: The form for user registration.
 --}}

@php
  use App\Enums\ClassStanding;
  use App\Enums\Gender;
@endphp

<x-form :route="$url"
        :model="$user"
        method="post">
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
