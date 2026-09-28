<?php

namespace App\Http\Requests\Admin;

use App\Services\MediaService;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
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
            'value' => ['nullable', 'string', 'max:20000'],
            'image' => MediaService::imageRules(false),
            'clear' => ['sometimes', 'boolean'],
        ];
    }
}
