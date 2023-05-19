<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded=[];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function images(){
        return $this->hasMany(Image::class,'post_id');

    }

    public function requests(){
        return $this->hasMany(Request::class,'post_id');
    }

    public function received_request() 
    {
        return $this->hasOne(Received::class);
    }


}
