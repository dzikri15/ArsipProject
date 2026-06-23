<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'email',
        'nim',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Relationships
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }

    public function foto()
    {
        return $this->hasMany(Foto::class);
    }

    public function video()
    {
        return $this->hasMany(Video::class);
    }

    public function link()
    {
        return $this->hasMany(Link::class);
    }

    public function log()
    {
        return $this->hasMany(Log::class);
    }

    // Accessors
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
