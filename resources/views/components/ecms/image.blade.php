{{-- Single-instance ECMS image. Falls back to the slot (a design
     placeholder box) when no image has been uploaded yet. --}}
@props(['section', 'key', 'alt' => ''])
@php
    $path = ecms("{$section}.{$key}");
@endphp
@if ($path)
    <img src="{{ Storage::url($path) }}" alt="{{ $alt }}" {{ $attributes }}>
@else
    {{ $slot }}
@endif
