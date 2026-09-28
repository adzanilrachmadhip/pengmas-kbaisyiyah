@props(['section', 'key', 'tag' => 'div', 'class' => ''])
@php
    // NOTE: value is trusted seeded/admin content. Once the admin rich-text
    // editor ships (Step 5), sanitize with mews/purifier before echoing raw.
    $value = ecms("{$section}.{$key}");
@endphp
@if ($value !== null && $value !== '')
    <{{ $tag }} {{ $attributes->merge(['class' => $class]) }}>{!! $value !!}</{{ $tag }}>
@endif
