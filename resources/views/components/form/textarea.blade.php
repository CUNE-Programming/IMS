{{--
file: resources/views/components/form/textarea.blade.php
author: Ian Kollipara
date: 2024-07-25
description: A form textarea component
 --}}

@props([
    "label" => null,
    "name",
    "id" => null,
    "value" => null,
    "wrapperClass" => ["flex", "flex-col"],
    "help" => null,
    "rich" => false,
])

@php
  $wrapperClass = is_array($wrapperClass) ? $wrapperClass : explode(" ", $wrapperClass);
  $id ??= "id--" . str($name)->slug();
  $label ??= str($name)->title();
@endphp

@aware(["model"])

<div x-data
     @class($wrapperClass)>
  <label class="font-cune-sub"
         for="{{ $id }}">{{ $label }}</label>
  @if ($rich)
    <input id="{{ $id }}"
           name="{{ $name }}"
           type="hidden"
           value="{{ old($name, $value ?? $model?->getAttribute($name)) }}">
    <trix-editor input="{{ $id }}"
                 {{ $attributes->class(["flex-1", "rounded", "border-none", "font-cune-text", "focus:ring-cune-wheat", "bg-white", "ring-red-800" => $errors->has($name)]) }}></trix-editor>
  @else
    <textarea id="{{ $id }}"
              name="{{ $name }}"
              {{ $attributes->class(["flex-1", "rounded", "border-none", "font-cune-text", "focus:ring-cune-wheat", "ring-red-800" => $errors->has($name)]) }}>{{ old($name, $value ?? $model?->getAttribute($name)) }}</textarea>
  @endif
  @if ($help)
    <p class="mx-2 text-sm text-cune-slate">{{ $help }}</p>
  @endif
  @error($name)
    <p class="text-sm text-red-800">{{ $message }}</p>
  @enderror
</div>
