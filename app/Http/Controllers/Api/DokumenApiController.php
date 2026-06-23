<?php

namespace App\Http\Controllers\Api;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DokumenApiController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();
        $query = Dokumen::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $dokumen = $query->latest()->paginate(15);
        return response()->json(['data' => $dokumen], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|max:51200',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = auth()->user();
            $file = $request->file('file');
            $path = $file->store('dokumen', 'public');
            $ukuran = round($file->getSize() / 1024 / 1024, 2) . ' MB';
            $tipe = strtoupper($file->getClientOriginalExtension());

            $dokumen = Dokumen::create([
                'judul' => $validated['judul'],
                'file_path' => $path,
                'ukuran' => $ukuran,
                'tipe' => $tipe,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user->id,
            ]);

            return response()->json(['data' => $dokumen, 'message' => 'Dokumen berhasil diupload'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengupload dokumen'], 500);
        }
    }

    public function show(Dokumen $dokumen): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $dokumen->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $dokumen->load('user')], 200);
    }

    public function update(Request $request, Dokumen $dokumen): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $dokumen->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $dokumen->update($validated);
            return response()->json(['data' => $dokumen, 'message' => 'Dokumen berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui dokumen'], 500);
        }
    }

    public function destroy(Dokumen $dokumen): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $dokumen->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($dokumen->file_path);
            $dokumen->delete();
            return response()->json(['message' => 'Dokumen berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus dokumen'], 500);
        }
    }

    public function download(Dokumen $dokumen)
    {
        if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($dokumen->file_path)) {
            return response()->json(['error' => 'File tidak ditemukan'], 404);
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->download($dokumen->file_path);
    }

    public function search($query): JsonResponse
    {
        $user = auth()->user();
        $results = Dokumen::where('judul', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%');

        if ($user->role !== 'admin') {
            $results->where('user_id', $user->id);
        }

        return response()->json(['data' => $results->get()], 200);
    }
}
