<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;

    protected $table = 'video';

    protected $fillable = [
        'judul',
        'file_path',
        'durasi',
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
        return '🎬';
    }

    public function getBadgeColorAttribute()
    {
        return '#fff3e0';
    }

    public function getBadgeTextColorAttribute()
    {
        return '#e65100';
    }
}
