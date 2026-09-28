<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;

class MessageController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => ContactMessage::query()->latest()->get(),
        ]);
    }

    public function markRead(ContactMessage $message): JsonResponse
    {
        $message->update(['status' => 'read']);

        return response()->json([
            'success' => true,
            'message' => 'Pesan ditandai sudah dibaca.',
            'data' => $message,
        ]);
    }

    public function destroy(ContactMessage $message): JsonResponse
    {
        $message->delete();

        return response()->json(['success' => true, 'message' => 'Pesan dihapus.']);
    }
}
