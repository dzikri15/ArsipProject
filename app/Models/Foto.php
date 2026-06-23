<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Foto extends Model
{
    use SoftDeletes;

    protected $table = 'foto';

    protected $fillable = [
        'judul',
        'file_path',
        'ukuran',
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
        return '🖼️';
    }

    public function getBadgeColorAttribute()
    {
        return '#e3f2fd';
    }

    public function getBadgeTextColorAttribute()
    {
        return '#1976d2';
    }
}
