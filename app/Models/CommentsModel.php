<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommentsModel extends Model
{
    protected $table = 'comments';
    protected $guarded = [];    

    public function revisi()
    {
        return $this->belongsTo(RevisiModel::class, 'revisions_id ');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
