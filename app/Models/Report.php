<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'post_id',
        
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

