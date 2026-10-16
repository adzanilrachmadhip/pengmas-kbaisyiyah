<?php

namespace App\Models;

use Database\Factories\EducationHistoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['staff_member_id', 'degree', 'institution', 'year'])]
class EducationHistory extends Model
{
    /** @use HasFactory<EducationHistoryFactory> */
    use HasFactory;

    public function staffMember()
    {
        return $this->belongsTo(StaffMember::class);
    }
}
