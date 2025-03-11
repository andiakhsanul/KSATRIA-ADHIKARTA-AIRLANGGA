<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimModel extends Model
{
    protected $table = 'tim';
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class, 'tim_id');
    }

    public function anggota()
    {
        return $this->hasMany(User::class);
    }

    public function ketua()
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }

    public function proposal()
    {
        return $this->hasOne(ProposalModel::class, 'tim_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviewer_tim', 'tim_id', 'reviewer_id');
    }

    public function jenisPkm()
    {
        return $this->belongsTo(JenisPKMModel::class, 'pkm_id');
    }

    public function proposals()
    {
        return $this->hasMany(ProposalModel::class, 'tim_id');
    }
}
