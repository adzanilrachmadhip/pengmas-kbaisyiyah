<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * The admin dashboard splits the one site_settings row across multiple
     * forms/panels (e.g. "Kelola Contact" vs "Pengaturan Situs"), each
     * submitting only the fields it owns. Every rule needs 'sometimes' so a
     * field absent from a given submission is skipped entirely — without it,
     * Eloquent's update() would overwrite it with null since 'nullable'
     * alone still validates (and includes) a missing key as null.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['sometimes', 'required', 'string', 'max:120'],
            'tagline' => ['sometimes', 'nullable', 'string', 'max:120'],
            'address' => ['sometimes', 'nullable', 'string', 'max:255'],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'email' => ['sometimes', 'nullable', 'email', 'max:150'],
            'instagram_handle' => ['sometimes', 'nullable', 'string', 'max:60'],
            'instagram_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'maps_embed_url' => ['sometimes', 'nullable', 'url', 'max:1000'],
            'operational_hours' => ['sometimes', 'nullable', 'string', 'max:120'],
        ];
    }
}
