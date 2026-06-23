<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';

    protected $fillable = [
        'user_id',
        'aksi',
        'model',
        'model_id',
        'keterangan',
        'ip_address',
    ];

    public $timestamps = true;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
