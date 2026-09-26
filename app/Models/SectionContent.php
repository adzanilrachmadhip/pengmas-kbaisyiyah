<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['section', 'key', 'value', 'type'])]
class SectionContent extends Model
{
    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Fetch all key => value pairs for a section as a plain array.
     */
    public static function forSection(string $section): array
    {
        return static::query()
            ->section($section)
            ->pluck('value', 'key')
            ->all();
    }
}
