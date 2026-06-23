<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Models\Log;

class AppHelper
{
    /**
     * Get current authenticated user from session or auth
     */
    public static function getCurrentUser()
    {
        if (Auth::check()) {
            return Auth::user();
        }
        
        return session('user');
    }

    /**
     * Check if user is admin
     */
    public static function isAdmin($user = null): bool
    {
        $user = $user ?? self::getCurrentUser();
        
        if (is_array($user)) {
            return $user['role'] === 'admin';
        }
        
        return $user?->role === 'admin';
    }

    /**
     * Log user activity
     */
    public static function logActivity($aksi, $model, $modelId, $keterangan = null): void
    {
        try {
            $user = self::getCurrentUser();
            $userId = is_array($user) ? $user['id'] : $user->id;

            Log::create([
                'user_id' => $userId,
                'aksi' => $aksi,
                'model' => $model,
                'model_id' => $modelId,
                'keterangan' => $keterangan,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            // Silently fail if logging fails
        }
    }

    /**
     * Format file size
     */
    public static function formatFileSize($bytes, $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }

    /**
     * Get file extension
     */
    public static function getFileExtension($filename): string
    {
        return strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
    }

    /**
     * Check authorization
     */
    public static function checkAuthorization($resource, $user = null): bool
    {
        $user = $user ?? self::getCurrentUser();
        $isAdmin = is_array($user) ? $user['role'] === 'admin' : $user?->role === 'admin';
        $userId = is_array($user) ? $user['id'] : $user?->id;

        if ($isAdmin) {
            return true;
        }

        $resourceUserId = is_array($resource) ? $resource['user_id'] : $resource?->user_id;
        
        return $userId === $resourceUserId;
    }
}
