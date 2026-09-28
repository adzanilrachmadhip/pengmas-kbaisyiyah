<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

#[Fillable(['section', 'key', 'value', 'type'])]
class SectionContent extends Model
{
    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Fetch all key => value pairs for a section as a plain array, cached
     * forever until a write invalidates it (see self::forget()).
     */
    public static function forSection(string $section): array
    {
        return Cache::rememberForever(
            static::cacheKey($section),
            fn () => static::query()->section($section)->pluck('value', 'key')->all()
        );
    }

    public static function forget(string $section): void
    {
        Cache::forget(static::cacheKey($section));
    }

    protected static function cacheKey(string $section): string
    {
        return "ecms.section.{$section}";
    }

    protected static function booted(): void
    {
        static::saved(fn (self $content) => static::forget($content->section));
        static::deleted(fn (self $content) => static::forget($content->section));
    }
}
