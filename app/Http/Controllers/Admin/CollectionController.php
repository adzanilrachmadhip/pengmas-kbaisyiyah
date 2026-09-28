<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CollectionItemRequest;
use App\Services\CollectionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct(private readonly CollectionService $collections) {}

    public function index(string $resource): JsonResponse
    {
        $config = $this->collections->config($resource);

        return response()->json([
            'success' => true,
            'data' => $this->collections->index($config),
        ]);
    }

    public function store(CollectionItemRequest $request, string $resource): JsonResponse
    {
        $config = $this->collections->config($resource);

        $model = $this->collections->create(
            $config,
            $request->safe()->except(['image']),
            $request->file('image')
        );

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil ditambahkan.',
            'data' => $model,
        ], 201);
    }

    public function update(CollectionItemRequest $request, string $resource, int $id): JsonResponse
    {
        $config = $this->collections->config($resource);
        $model = $config['model']::query()->findOrFail($id);

        $model = $this->collections->update(
            $config,
            $model,
            $request->safe()->except(['image']),
            $request->file('image')
        );

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil diperbarui.',
            'data' => $model,
        ]);
    }

    public function destroy(string $resource, int $id): JsonResponse
    {
        $config = $this->collections->config($resource);
        $model = $config['model']::query()->findOrFail($id);

        $this->collections->destroy($config, $model);

        return response()->json([
            'success' => true,
            'message' => 'Item berhasil dihapus.',
        ]);
    }

    public function reorder(Request $request, string $resource): JsonResponse
    {
        $config = $this->collections->config($resource);
        abort_unless($config['has_sort'], 422, 'Koleksi ini tidak mendukung pengurutan.');

        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer'],
        ]);

        $this->collections->reorder($config, $validated['ids']);

        return response()->json(['success' => true, 'message' => 'Urutan berhasil diperbarui.']);
    }

    public function status(Request $request, string $resource, int $id): JsonResponse
    {
        $config = $this->collections->config($resource);
        abort_unless($config['has_status'], 422, 'Koleksi ini tidak mendukung status publikasi.');

        $validated = $request->validate([
            'status' => ['required', 'in:draft,published'],
        ]);

        $model = $config['model']::query()->findOrFail($id);
        $model = $this->collections->setStatus($config, $model, $validated['status']);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui.',
            'data' => $model,
        ]);
    }
}
