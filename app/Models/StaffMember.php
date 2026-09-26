<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'role', 'photo_path', 'initials', 'sort_order', 'status'])]
class StaffMember extends Model
{
    /** @use HasFactory<\Database\Factories\StaffMemberFactory> */
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
