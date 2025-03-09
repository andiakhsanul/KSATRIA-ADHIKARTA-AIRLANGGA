<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevisiModel extends Model
{
    protected $table = 'revisi';
    protected $guarded = [];

    public function proposal()
    {
        return $this->belongsTo(ProposalModel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }
}
