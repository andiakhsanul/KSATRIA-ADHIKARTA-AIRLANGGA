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

    public function reviewers()
    {
        return $this->hasManyThrough(
            User::class,
            ReviewerTimModel::class,
            'tim_id',       // Foreign key di reviewer_tim (relasi ke tim)
            'id',           // Primary key di users (reviewer)
            'tim_id',       // Foreign key di proposal (relasi ke tim)
            'reviewer_id'   // Foreign key di reviewer_tim (relasi ke users)
        );
    }
}
