<?php

namespace App\Services;

use App\Models\SectionContent;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class ContentService
{
    public function __construct(private readonly MediaService $media) {}

    /**
     * Update a single-instance content field. Text/richtext fields take a
     * plain string; image fields take an uploaded file (or a `clear` flag
     * to remove the current image).
     */
    public function update(SectionContent $content, ?string $value, ?UploadedFile $file, bool $clear): SectionContent
    {
        if ($content->type === 'image') {
            if ($file) {
                $content->value = $this->media->replace($file, "ecms/{$content->section}", $content->value);
            } elseif ($clear) {
                $this->media->delete($content->value);
                $content->value = null;
            }
        } else {
            if ($value === null) {
                throw ValidationException::withMessages(['value' => 'Nilai wajib diisi.']);
            }

            $content->value = $value;
        }

        $content->save();

        return $content;
    }
}
