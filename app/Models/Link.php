<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Link extends Model
{
    use SoftDeletes;

    protected $table = 'link';

    protected $fillable = [
        'judul',
        'url',
        'deskripsi',
        'kategori',
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
        return '🔗';
    }

    public function getBadgeColorAttribute()
    {
        return '#fce4ec';
    }

    public function getBadgeTextColorAttribute()
    {
        return '#c2185b';
    }
}
