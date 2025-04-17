<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovedTeamsModel extends Model
{
    protected $table = 'approved_teams';
    protected $guarded = [];
    public function tim()
    {
        return $this->belongsTo(TimModel::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function proposal(){
        return $this->hasOne(ProposalModel::class, 'tim_id');
    }
}