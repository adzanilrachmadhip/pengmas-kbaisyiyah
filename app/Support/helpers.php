<?php

use App\Models\SectionContent;

if (! function_exists('ecms')) {

    function ecms(string $sectionDotKey, ?string $default = null): ?string
    {
        [$section, $key] = explode('.', $sectionDotKey, 2);

        return SectionContent::forSection($section)[$key] ?? $default;
    }
}
