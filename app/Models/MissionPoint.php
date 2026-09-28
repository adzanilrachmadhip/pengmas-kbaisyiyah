<?php

namespace App\Models;

use Database\Factories\MissionPointFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['content', 'sort_order', 'status'])]
class MissionPoint extends Model
{
    /** @use HasFactory<MissionPointFactory> */
    use HasFactory, SoftDeletes;

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
