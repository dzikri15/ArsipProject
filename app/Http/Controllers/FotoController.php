<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoController extends Controller
{
    public function index()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        $query = Foto::with('user');
        
        if (!$isAdmin) {
            $query->where('user_id', $user['id']);
        }

        $foto = $query->latest()->paginate(15);
        return view('pages.foto', compact('foto', 'user', 'isAdmin'));
    }

    public function create()
    {
        $user = session('user');
        return view('pages.foto-create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|image|max:10240',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = session('user');
            $file = $request->file('file');
            $path = $file->store('foto', 'public');
            $ukuran = round($file->getSize() / 1024 / 1024, 2) . ' MB';

            $foto = Foto::create([
                'judul' => $validated['judul'],
                'file_path' => $path,
                'ukuran' => $ukuran,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user['id'],
            ]);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'upload_foto',
                'model' => 'Foto',
                'model_id' => $foto->id,
                'keterangan' => 'Mengupload foto: ' . $foto->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('foto')->with('success', 'Foto berhasil diupload');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupload foto']);
        }
    }

    public function show($id)
    {
        $user = session('user');
        $foto = Foto::findOrFail($id);

        if ($user['role'] !== 'admin' && $foto->user_id !== $user['id']) {
            abort(403);
        }

        return view('pages.foto-show', compact('foto', 'user'));
    }

    public function edit($id)
    {
        $user = session('user');
        $foto = Foto::findOrFail($id);

        if ($user['role'] !== 'admin' && $foto->user_id !== $user['id']) {
            abort(403);
        }

        return view('pages.foto-edit', compact('foto', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        $foto = Foto::findOrFail($id);

        if ($user['role'] !== 'admin' && $foto->user_id !== $user['id']) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $foto->update($validated);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'update_foto',
                'model' => 'Foto',
                'model_id' => $foto->id,
                'keterangan' => 'Update foto: ' . $foto->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('foto')->with('success', 'Foto berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui foto']);
        }
    }

    public function destroy($id)
    {
        $user = session('user');
        $foto = Foto::findOrFail($id);

        if ($user['role'] !== 'admin' && $foto->user_id !== $user['id']) {
            abort(403);
        }

        try {
            Storage::disk('public')->delete($foto->file_path);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'delete_foto',
                'model' => 'Foto',
                'model_id' => $foto->id,
                'keterangan' => 'Hapus foto: ' . $foto->judul,
                'ip_address' => request()->ip(),
            ]);

            $foto->delete();
            return redirect()->route('foto')->with('success', 'Foto berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus foto']);
        }
    }
}
