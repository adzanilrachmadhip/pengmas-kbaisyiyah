<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContentRequest;
use App\Models\SectionContent;
use App\Services\ContentService;
use Illuminate\Http\JsonResponse;

class ContentController extends Controller
{
    public function update(UpdateContentRequest $request, string $section, string $key, ContentService $service): JsonResponse
    {
        $content = SectionContent::query()
            ->where('section', $section)
            ->where('key', $key)
            ->firstOrFail();

        $content = $service->update(
            $content,
            $request->input('value'),
            $request->file('image'),
            $request->boolean('clear')
        );

        return response()->json([
            'success' => true,
            'message' => 'Konten berhasil diperbarui.',
            'data' => $content,
            'errors' => null,
        ]);
    }
}
