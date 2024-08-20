{{--
file: resources/views/components/form/select.blade.php
author: Ian Kollipara
date: 2024-07-25
description: A form select component
 --}}

@props([
    "label" => null,
    "name",
    "id" => null,
    "options" => [],
    "value" => null,
    "wrapperClass" => ["flex", "flex-col"],
    "multiple" => false,
    "help" => null,
    "config" => "{}",
])

@php
  $wrapperClass = is_array($wrapperClass) ? $wrapperClass : explode(" ", $wrapperClass);
  $id ??= "id--" . str($name)->slug();
  $label ??= str($name)->title();
@endphp

@aware(["model"])

<div @class($wrapperClass)>
  <label class="font-cune-sub"
         for="{{ $id }}">{{ $label }}</label>
  <select id="{{ $id }}"
          name="{{ $multiple ? $name . "[]" : $name }}"
          x-data="select({!! $config !!})"
          @if ($multiple) multiple @endif
          {{ $attributes->class(["flex-1", "rounded", "border-none", "font-cune-text", "focus:ring-cune-wheat", "ring-red-800" => $errors->has($name)]) }}>
    @foreach ($options as $optionValue => $optionLabel)
      <option value="{{ $optionValue }}"
              @if (old($name, $value ?? $model?->getAttribute($name)) == $optionValue) selected @endif>
        {{ $optionLabel }}
      </option>
    @endforeach
  </select>
  @if ($help)
    <p class="mx-2 text-sm text-cune-slate">{{ $help }}</p>
  @endif
  @error($name)
    <p class="text-sm text-red-800">{{ $message }}</p>
  @enderror
</div>
