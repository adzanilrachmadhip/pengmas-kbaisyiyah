@props(['section', 'key', 'tag' => 'div', 'class' => ''])
@php
    // NOTE: admin-submitted values are sanitized with mews/purifier on save
    // (ContentService::update()) before they ever reach storage — safe to
    // echo raw here. Seeded values are our own trusted markup.
    $value = ecms("{$section}.{$key}");
@endphp
@if ($value !== null && $value !== '')
    <{{ $tag }} {{ $attributes->merge(['class' => $class]) }}>{!! $value !!}</{{ $tag }}>
@endif
