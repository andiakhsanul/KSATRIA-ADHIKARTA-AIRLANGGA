<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPKMModel extends Model
{
    protected $table = 'jenis_pkm';
    protected $guarded = [];

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviewer_jenis_pkm', 'pkm_id', 'reviewer_id');
    }
    
    public function proposals()
    {
        return $this->hasMany(ProposalModel::class, 'pkm_id');
    }
}
