<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * Generic CRUD for every collection registered in config('ecms.collections').
 * Keeping this config-driven (rather than one controller per collection) is
 * what lets a brand-new section skip touching this class entirely — see
 * config/ecms.php and docs/ECMS.md.
 */
class CollectionService
{
    public function __construct(
        private readonly MediaService $media,
        private readonly RichTextSanitizer $sanitizer,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function config(string $resource): array
    {
        $config = config("ecms.collections.{$resource}");

        abort_if($config === null, 404, "Unknown ECMS collection [{$resource}].");

        return $config;
    }

    /**
     * @return array<int, Model>
     */
    public function index(array $config)
    {
        $query = $config['model']::query();

        return $config['has_sort'] ? $query->ordered()->get() : $query->latest()->get();
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(array $config, array $data, ?UploadedFile $file): Model
    {
        /** @var Model $model */
        $model = new $config['model'];
        $this->fill($model, $config, $data, $file);

        if ($config['has_sort']) {
            $model->sort_order = ($config['model']::query()->max('sort_order') ?? 0) + 1;
        }

        if ($config['has_status'] && ! $model->status) {
            $model->status = 'draft';
        }

        $model->save();

        return $model;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function update(array $config, Model $model, array $data, ?UploadedFile $file): Model
    {
        $this->fill($model, $config, $data, $file);
        $model->save();

        return $model;
    }

    public function destroy(array $config, Model $model): void
    {
        if ($config['image_field'] && $model->{$config['image_field']}) {
            $this->media->delete($model->{$config['image_field']});
        }

        $model->delete();
    }

    /**
     * @param  array<int, int>  $orderedIds
     */
    public function reorder(array $config, array $orderedIds): void
    {
        foreach ($orderedIds as $position => $id) {
            $config['model']::query()->whereKey($id)->update(['sort_order' => $position + 1]);
        }
    }

    public function setStatus(array $config, Model $model, string $status): Model
    {
        $model->update(['status' => $status]);

        return $model;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function fill(Model $model, array $config, array $data, ?UploadedFile $file): void
    {
        foreach ($config['fields'] as $field) {
            if ($field['type'] === 'image') {
                continue;
            }

            if (array_key_exists($field['name'], $data)) {
                $model->{$field['name']} = match ($field['type']) {
                    'boolean' => (bool) $data[$field['name']],
                    'richtext' => $this->sanitizer->sanitize((string) $data[$field['name']]),
                    default => $data[$field['name']],
                };
            } elseif ($field['type'] === 'boolean') {
                $model->{$field['name']} = false;
            }
        }

        // Auto-slug: if the collection has a 'slug' field left blank, derive
        // it from the label field (e.g. article title) instead of failing.
        $hasSlugField = collect($config['fields'])->contains('name', 'slug');
        if ($hasSlugField && empty($model->slug)) {
            $source = $data[$config['label_field']] ?? $model->{$config['label_field']} ?? Str::random(8);
            $model->slug = Str::slug($source);
        }

        if ($config['image_field'] && $file) {
            $model->{$config['image_field']} = $this->media->replace(
                $file,
                "ecms/{$config['image_field']}",
                $model->{$config['image_field']}
            );
        }
    }
}
