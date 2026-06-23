<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dokumen extends Model
{
    use SoftDeletes;

    protected $table = 'dokumen';

    protected $fillable = [
        'judul',
        'file_path',
        'ukuran',
        'tipe',
        'deskripsi',
        'user_id',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors for icons and badges
    public function getIconAttribute()
    {
        $icons = ['PDF' => '📄', 'DOC' => '📝', 'DOCX' => '📝', 'XLS' => '📊', 'XLSX' => '📊'];
        return $icons[$this->tipe] ?? '📎';
    }

    public function getBadgeColorAttribute()
    {
        $colors = ['PDF' => '#e3f2fd', 'DOC' => '#f3e5f5', 'DOCX' => '#f3e5f5', 'XLS' => '#e8f5e9', 'XLSX' => '#e8f5e9'];
        return $colors[$this->tipe] ?? '#f5f5f5';
    }

    public function getBadgeTextColorAttribute()
    {
        $colors = ['PDF' => '#1976d2', 'DOC' => '#7b1fa2', 'DOCX' => '#7b1fa2', 'XLS' => '#388e3c', 'XLSX' => '#388e3c'];
        return $colors[$this->tipe] ?? '#666';
    }
}
