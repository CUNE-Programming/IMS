{{--
file: resources/views/components/button/a.blade.php
author: Ian Kollipara & Aidan Nachi
date: 2024-06-11
description: This file contains the HTML for the button component.
 --}}

<a
    {{ $attributes->class(["border border-gray-50 rounded-md px-2 py-1 hover:bg-gray-50 hover:text-blue-500 transition-colors"]) }}>
    {{ $slot }}
</a>
