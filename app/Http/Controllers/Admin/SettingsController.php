<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingsRequest;
use App\Models\SiteSetting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function update(UpdateSettingsRequest $request): JsonResponse
    {
        $settings = SiteSetting::current();
        $settings->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan situs berhasil diperbarui.',
            'data' => $settings,
        ]);
    }
}
