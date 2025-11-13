<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // berikut opsional — jika kamu menambahkan kolom di migration
        'is_admin', // boolean flag sederhana
        'role',     // alternatif: 'admin', 'user', dll.
    ];

    /**
     * The attributes that should be hidden for arrays / serialization.
     *
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Helper untuk cek apakah user adalah admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        // Cek flag boolean lebih dulu, lalu cek kolom role bila ada
        if (!is_null($this->is_admin) && $this->is_admin === true) {
            return true;
        }

        if (!empty($this->role) && strtolower($this->role) === 'admin') {
            return true;
        }

        return false;
    }
}
