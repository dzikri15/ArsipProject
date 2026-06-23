<?php

namespace App\Http\Controllers\Api;

use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FotoApiController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();
        $query = Foto::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $foto = $query->latest()->paginate(15);
        return response()->json(['data' => $foto], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|image|max:10240',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = auth()->user();
            $file = $request->file('file');
            $path = $file->store('foto', 'public');
            $ukuran = round($file->getSize() / 1024 / 1024, 2) . ' MB';

            $foto = Foto::create([
                'judul' => $validated['judul'],
                'file_path' => $path,
                'ukuran' => $ukuran,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user->id,
            ]);

            return response()->json(['data' => $foto, 'message' => 'Foto berhasil diupload'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengupload foto'], 500);
        }
    }

    public function show(Foto $foto): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $foto->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $foto->load('user')], 200);
    }

    public function update(Request $request, Foto $foto): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $foto->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $foto->update($validated);
            return response()->json(['data' => $foto, 'message' => 'Foto berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui foto'], 500);
        }
    }

    public function destroy(Foto $foto): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $foto->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($foto->file_path);
            $foto->delete();
            return response()->json(['message' => 'Foto berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus foto'], 500);
        }
    }

    public function search($query): JsonResponse
    {
        $user = auth()->user();
        $results = Foto::where('judul', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%');

        if ($user->role !== 'admin') {
            $results->where('user_id', $user->id);
        }

        return response()->json(['data' => $results->get()], 200);
    }
}
