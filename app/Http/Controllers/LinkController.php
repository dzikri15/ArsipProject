<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function index()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        $query = Link::with('user');
        
        if (!$isAdmin) {
            $query->where('user_id', $user['id']);
        }

        $link = $query->latest()->paginate(15);
        return view('pages.link', compact('link', 'user', 'isAdmin'));
    }

    public function create()
    {
        $user = session('user');
        return view('pages.link-create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'url' => 'required|url',
            'kategori' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = session('user');

            $link = Link::create([
                'judul' => $validated['judul'],
                'url' => $validated['url'],
                'kategori' => $validated['kategori'] ?? null,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user['id'],
            ]);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'create_link',
                'model' => 'Link',
                'model_id' => $link->id,
                'keterangan' => 'Tambah link: ' . $link->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('link')->with('success', 'Link berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menambahkan link']);
        }
    }

    public function show($id)
    {
        $user = session('user');
        $link = Link::findOrFail($id);

        if ($user['role'] !== 'admin' && $link->user_id !== $user['id']) {
            abort(403);
        }

        return view('pages.link-show', compact('link', 'user'));
    }

    public function edit($id)
    {
        $user = session('user');
        $link = Link::findOrFail($id);

        if ($user['role'] !== 'admin' && $link->user_id !== $user['id']) {
            abort(403);
        }

        return view('pages.link-edit', compact('link', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        $link = Link::findOrFail($id);

        if ($user['role'] !== 'admin' && $link->user_id !== $user['id']) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'url' => 'required|url',
            'kategori' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $link->update($validated);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'update_link',
                'model' => 'Link',
                'model_id' => $link->id,
                'keterangan' => 'Update link: ' . $link->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('link')->with('success', 'Link berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui link']);
        }
    }

    public function destroy($id)
    {
        $user = session('user');
        $link = Link::findOrFail($id);

        if ($user['role'] !== 'admin' && $link->user_id !== $user['id']) {
            abort(403);
        }

        try {
            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'delete_link',
                'model' => 'Link',
                'model_id' => $link->id,
                'keterangan' => 'Hapus link: ' . $link->judul,
                'ip_address' => request()->ip(),
            ]);

            $link->delete();
            return redirect()->route('link')->with('success', 'Link berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus link']);
        }
    }
}
