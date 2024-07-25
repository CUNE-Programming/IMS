{{--
file: resources/views/components/form/file.blade.php
author: Ian Kollipara
date: 2024-07-25
description: A form file component
 --}}

@props([
    "label" => null,
    "name",
    "id" => null,
    "value" => null,
    "wrapperClass" => ["flex", "flex-col"],
    "help" => null,
])

@php
  $wrapperClass = is_array($wrapperClass) ? $wrapperClass : explode(" ", $wrapperClass);
  $id ??= "id--" . str($name)->slug();
  $label ??= str($name)->title();
@endphp

@aware(["model"])

<div data-controller="form--file"
     data-form--file-file-value="{{ old($name, $value ?? $model?->getAttribute($name)) }}"
     @class($wrapperClass)>
  <label class="font-cune-sub"
         for="{{ $id }}">{{ $label }}</label>
  <input id="{{ $id }}"
         name="{{ $name }}"
         data-form--file-target="input"
         {{ $attributes->merge(["type" => "file", "value" => old($name, $value ?? $model?->getAttribute($name))]) }}>
  @if ($help)
    <p class="mx-2 text-sm text-cune-slate">{{ $help }}</p>
  @endif
  @error($name)
    <p class="text-sm text-red-800">{{ $message }}</p>
  @enderror
</div>
