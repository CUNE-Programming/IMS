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
  <x-form.textarea name="description"
                   rich />
</x-form>
