<?php

namespace App\Models;

use Database\Factories\StaffMemberFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'role', 'photo_path', 'initials', 'sort_order', 'status'])]
class StaffMember extends Model
{
    /** @use HasFactory<StaffMemberFactory> */
    use HasFactory, SoftDeletes;

    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * 'initials' isn't admin-editable (see config/ecms.php — the admin form
     * uploads a photo instead), it's only a fallback avatar for when no
     * photo has been uploaded yet, so it's derived from the name here
     * instead of asking the admin to type it in.
     */
    protected static function booted(): void
    {
        // Recomputed on every save (not just when empty) since the admin
        // form no longer exposes 'initials' at all — if it only fired once,
        // editing a typo'd name later would leave the old initials stale.
        static::saving(function (self $staff) {
            if ($staff->isDirty('name') || ! $staff->initials) {
                $staff->initials = static::deriveInitials($staff->name);
            }
        });
    }

    protected static function deriveInitials(string $name): string
    {
        $initials = collect(preg_split('/\s+/', trim($name)))
            ->filter()
            ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->take(2)
            ->implode('');

        return $initials ?: '?';
    }
}
