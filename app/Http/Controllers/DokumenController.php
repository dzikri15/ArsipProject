<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        
        $query = Dokumen::with('user');
        
        // If user is not admin, only show their own dokumen
        if (!$isAdmin) {
            $query->where('user_id', $user['id']);
        }

        $dokumen = $query->latest()->paginate(15);

        return view('pages.dokumen', compact('dokumen', 'user', 'isAdmin'));
    }

    public function create()
    {
        $user = session('user');
        return view('pages.dokumen-create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|file|max:51200',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = session('user');
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
                'user_id' => $user['id'],
            ]);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'upload_dokumen',
                'model' => 'Dokumen',
                'model_id' => $dokumen->id,
                'keterangan' => 'Mengupload dokumen: ' . $dokumen->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('dokumen')->with('success', 'Dokumen berhasil diupload');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupload dokumen: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $user = session('user');
        $dokumen = Dokumen::findOrFail($id);

        // Check authorization
        if ($user['role'] !== 'admin' && $dokumen->user_id !== $user['id']) {
            abort(403, 'Unauthorized');
        }

        return view('pages.dokumen-show', compact('dokumen', 'user'));
    }

    public function edit($id)
    {
        $user = session('user');
        $dokumen = Dokumen::findOrFail($id);

        // Check authorization
        if ($user['role'] !== 'admin' && $dokumen->user_id !== $user['id']) {
            abort(403, 'Unauthorized');
        }

        return view('pages.dokumen-edit', compact('dokumen', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        $dokumen = Dokumen::findOrFail($id);

        // Check authorization
        if ($user['role'] !== 'admin' && $dokumen->user_id !== $user['id']) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $dokumen->update($validated);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'update_dokumen',
                'model' => 'Dokumen',
                'model_id' => $dokumen->id,
                'keterangan' => 'Update dokumen: ' . $dokumen->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('dokumen')->with('success', 'Dokumen berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui dokumen']);
        }
    }

    public function destroy($id)
    {
        $user = session('user');
        $dokumen = Dokumen::findOrFail($id);

        // Check authorization
        if ($user['role'] !== 'admin' && $dokumen->user_id !== $user['id']) {
            abort(403, 'Unauthorized');
        }

        try {
            Storage::disk('public')->delete($dokumen->file_path);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'delete_dokumen',
                'model' => 'Dokumen',
                'model_id' => $dokumen->id,
                'keterangan' => 'Hapus dokumen: ' . $dokumen->judul,
                'ip_address' => request()->ip(),
            ]);

            $dokumen->delete();

            return redirect()->route('dokumen')->with('success', 'Dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus dokumen']);
        }
    }

    public function preview($id)
    {
        $user = session('user');
        $dokumen = Dokumen::findOrFail($id);

        if ($user['role'] !== 'admin' && $dokumen->user_id !== $user['id']) {
            abort(403, 'Unauthorized');
        }

        $publicPath = public_path('storage/' . $dokumen->file_path);

        if (!file_exists($publicPath)) {
            abort(404, 'File tidak ditemukan');
        }

        $mime = mime_content_type($publicPath) ?: 'application/octet-stream';
        $name = basename($publicPath);

        return response()->file($publicPath, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ]);
    }

    public function download($id)
    {
        $user = session('user');
        $dokumen = Dokumen::findOrFail($id);

        $publicPath = public_path('storage/' . $dokumen->file_path);

        if (!file_exists($publicPath)) {
            return back()->withErrors(['error' => 'File tidak ditemukan']);
        }

        LogModel::create([
            'user_id' => $user['id'],
            'aksi' => 'download_dokumen',
            'model' => 'Dokumen',
            'model_id' => $dokumen->id,
            'keterangan' => 'Download dokumen: ' . $dokumen->judul,
            'ip_address' => request()->ip(),
        ]);

        return response()->download($publicPath, basename($publicPath));
    }
}
