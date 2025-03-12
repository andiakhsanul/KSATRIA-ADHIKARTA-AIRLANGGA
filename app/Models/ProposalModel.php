<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProposalModel extends Model
{
    protected $table = 'proposal';
    protected $guarded = [];

    public function tim()
    {
        return $this->belongsTo(TimModel::class, 'tim_id');
    }
    public function reviews()
    {
        return $this->hasMany(ReviewModel::class, 'proposal_id');
    }
    public function revisions()
    {
        return $this->hasMany(RevisiModel::class, 'proposal_id');
    }

    public function jenisPkm()
    {
        return $this->belongsTo(JenisPKMModel::class, 'pkm_id');
    }

    public function reviewers()
    {
        return $this->belongsToMany(User::class, 'reviewer_tim', 'tim_id', 'reviewer_id');
    }


}
