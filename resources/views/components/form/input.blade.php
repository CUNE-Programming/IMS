{{--
file: resources/views/components/form/input.blade.php
author: Ian Kollipara
date: 2024-07-25
description: A form input component
 --}}

@props([
    "label" => null,
    "name",
    "id" => null,
    "type" => "text",
    "value" => null,
    "wrapperClass" => ["flex", "flex-col"],
    "help" => null,
])

@php
  $wrapperClass = is_array($wrapperClass) ? $wrapperClass : explode(" ", $wrapperClass);
  $id ??= "id--" . str($name)->slug();
  $label ??= str($name)->title();
  $errorName = str($name)->contains(["[", "]"])
      ? str($name)->before("[")->__toString() . "." . str($name)->between("[", "]")->__toString()
      : $name;
@endphp

@aware(["model"])

<div @class($wrapperClass)>
  <label class="font-cune-sub"
         for="{{ $id }}">{{ $label }}</label>
  <input id="{{ $id }}"
         name="{{ $name }}"
         {{ $attributes->class(["flex-1 rounded border-none font-cune-text focus:ring-cune-wheat", "ring-red-800" => $errors->has($name)])->merge(["type" => $type, "value" => old($name, $value ?? $model?->getAttribute($name))]) }}>
  @if ($help)
    <p class="mx-2 text-sm text-cune-slate">{{ $help }}</p>
  @endif
  @error($errorName ?? $name)
    <p class="text-sm text-red-800">{{ $message }}</p>
  @enderror
</div>
