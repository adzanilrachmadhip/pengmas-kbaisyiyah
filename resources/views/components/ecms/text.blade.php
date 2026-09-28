@props(['section', 'key', 'tag' => 'p', 'class' => ''])
@php
    $value = ecms("{$section}.{$key}");
@endphp
@if ($value !== null && $value !== '')
    <{{ $tag }} {{ $attributes->merge(['class' => $class]) }}>{{ $value }}</{{ $tag }}>
@endif
