<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'site_name',
    'tagline',
    'logo_path',
    'address',
    'phone',
    'email',
    'instagram_handle',
    'instagram_url',
    'maps_embed_url',
    'operational_hours',
])]
class SiteSetting extends Model
{
    /**
     * There is only ever one settings row. Fetch (and lazily create) it.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'site_name' => config('app.name'),
        ]);
    }
}
