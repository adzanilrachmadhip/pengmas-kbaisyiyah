<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public const MAX_KILOBYTES = 2048; // 2 MB

    public const ALLOWED_MIMES = ['jpeg', 'jpg', 'png', 'webp', 'gif'];

    /**
     * Validation rules for an incoming image upload. SVG is deliberately
     * excluded from ALLOWED_MIMES — it isn't raster-safe without an XML
     * sanitize pass, which this project doesn't have (see docs/ECMS.md).
     *
     * @return array<int, string>
     */
    public static function imageRules(bool $required = false): array
    {
        return [
            $required ? 'required' : 'nullable',
            'image',
            'mimes:'.implode(',', self::ALLOWED_MIMES),
            'max:'.self::MAX_KILOBYTES,
        ];
    }

    /**
     * Store an uploaded image on the public disk under $directory with a
     * randomized name, and return its stored path (relative to the disk).
     */
    public function store(UploadedFile $file, string $directory): string
    {
        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();

        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Replace an existing image: store the new upload, delete the old file
     * (if any), and return the new path.
     */
    public function replace(UploadedFile $file, string $directory, ?string $existingPath): string
    {
        $path = $this->store($file, $directory);

        if ($existingPath) {
            $this->delete($existingPath);
        }

        return $path;
    }

    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
