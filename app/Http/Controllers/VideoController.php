<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Log as LogModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';
        $query = Video::with('user');
        
        if (!$isAdmin) {
            $query->where('user_id', $user['id']);
        }

        $video = $query->latest()->paginate(15);
        return view('pages.video', compact('video', 'user', 'isAdmin'));
    }

    public function create()
    {
        $user = session('user');
        return view('pages.video-create', compact('user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'file' => 'required|mimetypes:video/mp4,video/avi,video/x-msvideo,video/x-matroska,video/quicktime,video/webm|max:524288',
            'durasi' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $user = session('user');
            $file = $request->file('file');
            $path = $file->store('video', 'public');
            $ukuran = round($file->getSize() / 1024 / 1024, 2) . ' MB';

            $video = Video::create([
                'judul' => $validated['judul'],
                'file_path' => $path,
                'ukuran' => $ukuran,
                'durasi' => $validated['durasi'] ?? null,
                'deskripsi' => $validated['deskripsi'] ?? null,
                'user_id' => $user['id'],
            ]);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'upload_video',
                'model' => 'Video',
                'model_id' => $video->id,
                'keterangan' => 'Mengupload video: ' . $video->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('video')->with('success', 'Video berhasil diupload');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal mengupload video']);
        }
    }

    public function show($id)
    {
        $user = session('user');
        $video = Video::findOrFail($id);

        if ($user['role'] !== 'admin' && $video->user_id !== $user['id']) {
            abort(403);
        }

        return view('pages.video-show', compact('video', 'user'));
    }

    public function edit($id)
    {
        $user = session('user');
        $video = Video::findOrFail($id);

        if ($user['role'] !== 'admin' && $video->user_id !== $user['id']) {
            abort(403);
        }

        return view('pages.video-edit', compact('video', 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = session('user');
        $video = Video::findOrFail($id);

        if ($user['role'] !== 'admin' && $video->user_id !== $user['id']) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'durasi' => 'nullable|string|max:20',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        try {
            $video->update($validated);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'update_video',
                'model' => 'Video',
                'model_id' => $video->id,
                'keterangan' => 'Update video: ' . $video->judul,
                'ip_address' => request()->ip(),
            ]);

            return redirect()->route('video')->with('success', 'Video berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal memperbarui video']);
        }
    }

    public function destroy($id)
    {
        $user = session('user');
        $video = Video::findOrFail($id);

        if ($user['role'] !== 'admin' && $video->user_id !== $user['id']) {
            abort(403);
        }

        try {
            Storage::disk('public')->delete($video->file_path);

            LogModel::create([
                'user_id' => $user['id'],
                'aksi' => 'delete_video',
                'model' => 'Video',
                'model_id' => $video->id,
                'keterangan' => 'Hapus video: ' . $video->judul,
                'ip_address' => request()->ip(),
            ]);

            $video->delete();
            return redirect()->route('video')->with('success', 'Video berhasil dihapus');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal menghapus video']);
        }
    }
}
