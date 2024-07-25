{{--
file: resources/views/components/form/index.blade.php
author: Ian Kollipara
date: 2024-07-25
description: A form builder component
 --}}

@props(["route", "method", "model" => null, "submitClass" => ["btn"], "submitText" => "Submit"])

@php
  $method = strtoupper($method);
  $submitClass = is_array($submitClass) ? $submitClass : explode(" ", $submitClass);
@endphp

<form {{ $attributes->class(["flex", "flex-col", "gap-3"]) }}
      action="{{ $route }}"
      method="post">
  @csrf
  @method($method)
  {{ $slot }}
  <button type="submit"
          @class($submitClass)>
    {{ $submitText }}
  </button>
</form>
