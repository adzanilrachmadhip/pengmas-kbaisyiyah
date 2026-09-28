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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:120'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'instagram_handle' => ['nullable', 'string', 'max:60'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'maps_embed_url' => ['nullable', 'url', 'max:1000'],
            'operational_hours' => ['nullable', 'string', 'max:120'],
        ];
    }
}
