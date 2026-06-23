<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Foto;
use App\Models\Video;
use App\Models\Link;
use Illuminate\Http\Request;

/**
 * PencarianController - Mencari arsip berdasarkan kata kunci
 */
class PencarianController extends Controller
{
    /**
     * Tampilkan halaman pencarian dengan hasil dari database
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q', '');
        $kategori = $request->query('kategori', 'semua');
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';

        $hasil = [];

        // Query Dokumen
        if ($kategori === 'semua' || $kategori === 'dokumen') {
            $query = Dokumen::with('user');
            if (!$isAdmin) {
                $query->where('user_id', $user['id']);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
                });
            }
            $dokumens = $query->latest()->get();
            foreach ($dokumens as $doc) {
                $hasil[] = [
                    'id' => $doc->id,
                    'judul' => $doc->judul,
                    'kategori' => 'dokumen',
                    'badge' => 'badge-blue',
                    'pemilik' => $doc->user->nama ?? 'N/A',
                    'tanggal' => $doc->created_at->format('d M Y'),
                ];
            }
        }

        // Query Foto
        if ($kategori === 'semua' || $kategori === 'foto') {
            $query = Foto::with('user');
            if (!$isAdmin) {
                $query->where('user_id', $user['id']);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
                });
            }
            $fotos = $query->latest()->get();
            foreach ($fotos as $foto) {
                $hasil[] = [
                    'id' => $foto->id,
                    'judul' => $foto->judul,
                    'kategori' => 'foto',
                    'badge' => 'badge-pink',
                    'pemilik' => $foto->user->nama ?? 'N/A',
                    'tanggal' => $foto->created_at->format('d M Y'),
                ];
            }
        }

        // Query Video
        if ($kategori === 'semua' || $kategori === 'video') {
            $query = Video::with('user');
            if (!$isAdmin) {
                $query->where('user_id', $user['id']);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%");
                });
            }
            $videos = $query->latest()->get();
            foreach ($videos as $video) {
                $hasil[] = [
                    'id' => $video->id,
                    'judul' => $video->judul,
                    'kategori' => 'video',
                    'badge' => 'badge-yellow',
                    'pemilik' => $video->user->nama ?? 'N/A',
                    'tanggal' => $video->created_at->format('d M Y'),
                ];
            }
        }

        // Query Link
        if ($kategori === 'semua' || $kategori === 'link') {
            $query = Link::with('user');
            if (!$isAdmin) {
                $query->where('user_id', $user['id']);
            }
            if ($keyword) {
                $query->where(function($q) use ($keyword) {
                    $q->where('judul', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%")
                      ->orWhere('url', 'like', "%{$keyword}%");
                });
            }
            $links = $query->latest()->get();
            foreach ($links as $link) {
                $hasil[] = [
                    'id' => $link->id,
                    'judul' => $link->judul,
                    'kategori' => 'link',
                    'badge' => 'badge-green',
                    'pemilik' => $link->user->nama ?? 'N/A',
                    'tanggal' => $link->created_at->format('d M Y'),
                ];
            }
        }

        // Sort by date descending
        usort($hasil, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return view('pages.pencarian', compact('hasil', 'keyword', 'kategori', 'user'));
    }
}

