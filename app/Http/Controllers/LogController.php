<?php

namespace App\Http\Controllers;

use App\Models\Log as LogModel;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $user = session('user');
        
        $query = LogModel::with('user');

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('aksi') && $request->aksi) {
            $query->where('aksi', 'like', '%' . $request->aksi . '%');
        }

        if ($request->has('model') && $request->model) {
            $query->where('model', $request->model);
        }

        $logs = $query->latest()->paginate(20);
        $users = User::all();

        return view('pages.log', compact('logs', 'users', 'user'));
    }

    public function export(Request $request)
    {
        $query = LogModel::with('user');

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('aksi') && $request->aksi) {
            $query->where('aksi', 'like', '%' . $request->aksi . '%');
        }

        if ($request->has('model') && $request->model) {
            $query->where('model', $request->model);
        }

        $logs = $query->latest()->get();

        $response = new StreamedResponse(function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['User', 'Aksi', 'Model', 'Model ID', 'Keterangan', 'IP Address', 'Waktu']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    $log->user->nama ?? '-',
                    $log->aksi,
                    $log->model,
                    $log->model_id,
                    $log->keterangan,
                    $log->ip_address,
                    $log->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="activity-logs.csv"');
        $response->headers->set('Content-Transfer-Encoding', 'binary');

        return $response;
    }
}
