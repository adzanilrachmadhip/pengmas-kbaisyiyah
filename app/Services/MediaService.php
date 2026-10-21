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
     * Indonesian validation messages for an image upload field, matching
     * the rest of the admin UI's language.
     *
     * 'uploaded' is the one that actually fires for an oversized file:
     * PHP rejects anything over its own upload_max_filesize before Laravel
     * ever validates, so the 'max' rule never gets a chance and the admin
     * would otherwise just see Laravel's generic English "The image failed
     * to upload."
     *
     * @return array<string, string>
     */
    public static function validationMessages(string $attribute = 'image'): array
    {
        return [
            "{$attribute}.uploaded" => 'Gagal mengunggah gambar — ukuran file melebihi batas. Maksimal '.self::maxLabel().'.',
            "{$attribute}.max" => 'Ukuran gambar maksimal '.self::maxLabel().'.',
            "{$attribute}.mimes" => 'Format gambar harus '.self::allowedLabel().'.',
            "{$attribute}.image" => 'File yang diunggah harus berupa gambar.',
        ];
    }

    /**
     * Human-readable limits for the admin UI hints and validation
     * messages, so the numbers only ever live in the constants above.
     */
    public static function hint(): string
    {
        return 'Format: '.self::allowedLabel().' · Maksimal '.self::maxLabel().'.';
    }

    public static function allowedLabel(): string
    {
        return collect(self::ALLOWED_MIMES)
            ->reject(fn ($ext) => $ext === 'jpeg') // jpg/jpeg is one format to a human
            ->map(fn ($ext) => strtoupper($ext))
            ->implode(', ');
    }

    public static function maxLabel(): string
    {
        return self::MAX_KILOBYTES % 1024 === 0
            ? (self::MAX_KILOBYTES / 1024).' MB'
            : self::MAX_KILOBYTES.' KB';
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
