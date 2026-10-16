<?php

namespace App\Http\Requests\Admin;

use App\Services\CollectionService;
use App\Services\MediaService;
use Illuminate\Foundation\Http\FormRequest;

class CollectionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // gated by the 'auth' + 'admin' route middleware
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $config = app(CollectionService::class)->config($this->route('resource'));

        $rules = [];
        foreach ($config['fields'] as $field) {
            if ($field['type'] === 'image') {
                continue;
            }

            if ($field['type'] === 'repeater') {
                $rules[$field['name']] = ['nullable', 'array'];
                foreach ($field['child_fields'] as $childField) {
                    $rules["{$field['name']}.*.{$childField['name']}"] = $childField['rules'] ?? ['nullable', 'string', 'max:255'];
                }

                continue;
            }

            $rules[$field['name']] = $field['rules'];
        }

        if ($config['image_field']) {
            $rules['image'] = MediaService::imageRules(false);
        }

        return $rules;
    }
}
