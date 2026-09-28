{{-- Shared inline SVG icons, ported 1:1 from proto/*.html so admin-editable
     "icon" fields (e.g. Feature::$icon) can reference them by name. --}}
@props(['name', 'size' => 22, 'stroke' => 'currentColor', 'strokeWidth' => '1.5'])
<svg width="{{ $size }}" height="{{ $size }}" viewBox="0 0 24 24" fill="none" stroke="{{ $stroke }}" stroke-width="{{ $strokeWidth }}" {{ $attributes }}>
    @switch($name)
        @case('logo')
            <path d="M12 3v18M4 8c2.5 0 4-1.5 4-4 0 2.5 1.5 4 4 4-2.5 0-4 1.5-4 4 0-2.5-1.5-4-4-4Zm12 8c2.5 0 4-1.5 4-4 0 2.5 1.5 4 4 4-2.5 0-4 1.5-4 4 0-2.5-1.5-4-4-4Z" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('book')
            <path d="M4 19.5V5.5A2.5 2.5 0 0 1 6.5 3H20v14H6.5a2.5 2.5 0 0 0 0 5H20"/>
            @break
        @case('people')
            <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.5-6 8-6s8 2 8 6"/>
            @break
        @case('play')
            <circle cx="12" cy="12" r="9"/><path d="M8 12h8M12 8v8"/>
            @break
        @case('shield')
            <path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6l-8-3Z"/>
            @break
        @case('camera')
            <rect x="3" y="5" width="18" height="14" rx="1"/><circle cx="9" cy="10" r="2"/><path d="m21 15-4-4-9 8"/>
            @break
        @case('location')
            <path d="M12 21s7-6.2 7-11.5A7 7 0 0 0 5 9.5C5 14.8 12 21 12 21Z"/><circle cx="12" cy="9.5" r="2.3"/>
            @break
        @case('phone')
            <path d="M4 5h16v14H4z"/><path d="m4 6 8 7 8-7"/>
            @break
        @case('email')
            <rect x="3" y="4" width="18" height="16" rx="2"/><path d="m4 7 8 6 8-6"/>
            @break
        @case('instagram')
            <rect x="3" y="3" width="18" height="18" rx="4"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="0.6" fill="{{ $stroke }}" stroke="none"/>
            @break
        @case('clock')
            <circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>
            @break
        @case('chevron-down')
            <path d="m6 9 6 6 6-6" stroke-linecap="round" stroke-linejoin="round"/>
            @break
        @case('menu')
            <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round"/>
            @break
        @case('close')
            <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/>
            @break
    @endswitch
</svg>
