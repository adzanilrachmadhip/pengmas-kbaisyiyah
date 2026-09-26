<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'title',
    'slug',
    'cover_image',
    'excerpt',
    'body',
    'published_at',
    'is_highlight',
    'status',
])]
class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory, SoftDeletes;

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'is_highlight' => 'boolean',
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('published_at');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
