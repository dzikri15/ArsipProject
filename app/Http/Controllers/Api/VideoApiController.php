<?php

namespace App\Http\Controllers\Api;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VideoApiController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();
        $query = Video::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $video = $query->latest()->paginate(15);
        return response()->json(['data' => $video], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|mimes:mp4,avi,mkv,mov,webm|max:512000',
            'durasi' => 'nullable|string',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = auth()->user();
            $file = $request->file('file');
            $path = $file->store('video', 'public');
            $ukuran = round($file->getSize() / 1024 / 1024, 2) . ' MB';

            $video = Video::create([
                'judul' => $validated['judul'],
                'file_path' => $path,
                'durasi' => $validated['durasi'] ?? null,
                'ukuran' => $ukuran,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user->id,
            ]);

            return response()->json(['data' => $video, 'message' => 'Video berhasil diupload'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengupload video'], 500);
        }
    }

    public function show(Video $video): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $video->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $video->load('user')], 200);
    }

    public function update(Request $request, Video $video): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $video->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'durasi' => 'nullable|string',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $video->update($validated);
            return response()->json(['data' => $video, 'message' => 'Video berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui video'], 500);
        }
    }

    public function destroy(Video $video): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $video->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($video->file_path);
            $video->delete();
            return response()->json(['message' => 'Video berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus video'], 500);
        }
    }

    public function search($query): JsonResponse
    {
        $user = auth()->user();
        $results = Video::where('judul', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%');

        if ($user->role !== 'admin') {
            $results->where('user_id', $user->id);
        }

        return response()->json(['data' => $results->get()], 200);
    }
}
