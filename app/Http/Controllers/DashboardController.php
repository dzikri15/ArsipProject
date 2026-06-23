<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\Foto;
use App\Models\Video;
use App\Models\Link;
use App\Models\Log as LogModel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = session('user');
        $isAdmin = $user['role'] === 'admin';

        // Get statistics
        $dokumenQuery = Dokumen::query();
        $fotoQuery = Foto::query();
        $videoQuery = Video::query();
        $linkQuery = Link::query();

        if (!$isAdmin) {
            $dokumenQuery->where('user_id', $user['id']);
            $fotoQuery->where('user_id', $user['id']);
            $videoQuery->where('user_id', $user['id']);
            $linkQuery->where('user_id', $user['id']);
        }

        $stats = [
            'dokumen' => $dokumenQuery->count(),
            'foto' => $fotoQuery->count(),
            'video' => $videoQuery->count(),
            'link' => $linkQuery->count(),
        ];

        // Get latest items
        $arsipTerbaru = [
            ...Dokumen::latest()->take(2)->get()->map(fn($d) => [
                'id' => $d->id,
                'type' => 'dokumen',
                'judul' => $d->judul,
                'kategori' => 'Dokumen',
                'badge' => 'badge-blue',
                'pemilik' => $d->user->nama ?? 'Unknown',
                'tanggal' => $d->created_at->format('d M Y'),
            ])->toArray(),
            ...Foto::latest()->take(2)->get()->map(fn($f) => [
                'id' => $f->id,
                'type' => 'foto',
                'judul' => $f->judul,
                'kategori' => 'Foto',
                'badge' => 'badge-pink',
                'pemilik' => $f->user->nama ?? 'Unknown',
                'tanggal' => $f->created_at->format('d M Y'),
            ])->toArray(),
            ...Video::latest()->take(2)->get()->map(fn($v) => [
                'id' => $v->id,
                'type' => 'video',
                'judul' => $v->judul,
                'kategori' => 'Video',
                'badge' => 'badge-yellow',
                'pemilik' => $v->user->nama ?? 'Unknown',
                'tanggal' => $v->created_at->format('d M Y'),
            ])->toArray(),
            ...Link::latest()->take(2)->get()->map(fn($l) => [
                'id' => $l->id,
                'type' => 'link',
                'judul' => $l->judul,
                'kategori' => 'Link',
                'badge' => 'badge-purple',
                'pemilik' => $l->user->nama ?? 'Unknown',
                'tanggal' => $l->created_at->format('d M Y'),
            ])->toArray(),
        ];
        
        // Sort by latest and take only 4 most recent
        usort($arsipTerbaru, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        $arsipTerbaru = array_slice($arsipTerbaru, 0, 4);

        // Get latest activity logs
        $logAktivitas = LogModel::with('user')
            ->latest()
            ->take(6)
            ->get()
            ->map(fn($log) => [
                'initial' => substr($log->user->nama ?? '', 0, 1),
                'action' => ucfirst(str_replace('_', ' ', $log->aksi)),
                'user' => $log->user->nama ?? 'Unknown',
                'waktu' => $log->created_at->diffForHumans(),
            ])
            ->toArray();

        return view('pages.dashboard', compact('stats', 'arsipTerbaru', 'logAktivitas', 'isAdmin', 'user'));
    }
}

