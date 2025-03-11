<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'nim',
        'nip',
        'role_id',
        'tim_id',
        'nama_lengkap',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function tim()
    {
        return $this->belongsTo(TimModel::class, 'tim_id');
    }

    public function teamsReviewed()
    {
        return $this->belongsToMany(TimModel::class, 'reviewer_tim', 'reviewer_id', 'tim_id');
    }

    public function role()
    {
        return $this->belongsTo(RoleModel::class);
    }

    public function jenisPKMReviewed()
    {
        return $this->belongsToMany(JenisPKMModel::class, 'reviewer_jenis_pkm', 'reviewer_id', 'pkm_id');
    }

}
