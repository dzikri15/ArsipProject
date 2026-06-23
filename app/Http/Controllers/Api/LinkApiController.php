<?php

namespace App\Http\Controllers\Api;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LinkApiController extends Controller
{
    public function index(): JsonResponse
    {
        $user = auth()->user();
        $query = Link::with('user');

        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        $link = $query->latest()->paginate(15);
        return response()->json(['data' => $link], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'url' => 'required|url',
            'kategori' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = auth()->user();

            $link = Link::create([
                'judul' => $validated['judul'],
                'url' => $validated['url'],
                'kategori' => $validated['kategori'] ?? null,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user->id,
            ]);

            return response()->json(['data' => $link, 'message' => 'Link berhasil ditambahkan'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menambahkan link'], 500);
        }
    }

    public function show(Link $link): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $link->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json(['data' => $link->load('user')], 200);
    }

    public function update(Request $request, Link $link): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $link->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'url' => 'required|url',
            'kategori' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $link->update($validated);
            return response()->json(['data' => $link, 'message' => 'Link berhasil diperbarui'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui link'], 500);
        }
    }

    public function destroy(Link $link): JsonResponse
    {
        $user = auth()->user();

        if ($user->role !== 'admin' && $link->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $link->delete();
            return response()->json(['message' => 'Link berhasil dihapus'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus link'], 500);
        }
    }

    public function search($query): JsonResponse
    {
        $user = auth()->user();
        $results = Link::where('judul', 'like', '%' . $query . '%')
            ->orWhere('deskripsi', 'like', '%' . $query . '%')
            ->orWhere('url', 'like', '%' . $query . '%');

        if ($user->role !== 'admin') {
            $results->where('user_id', $user->id);
        }

        return response()->json(['data' => $results->get()], 200);
    }

    public function getByCategory($category): JsonResponse
    {
        $user = auth()->user();
        $results = Link::where('kategori', $category);

        if ($user->role !== 'admin') {
            $results->where('user_id', $user->id);
        }

        return response()->json(['data' => $results->get()], 200);
    }
}
