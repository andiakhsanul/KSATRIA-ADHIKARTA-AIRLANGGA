<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
    protected $table = 'review';
    protected $guarded = [];
    public function proposal()
    {
        return $this->belongsTo(ProposalModel::class);
    }

    public function revisi()
    {
        return $this->belongsTo(RevisiModel::class, 'revisi_id');
    }

}
