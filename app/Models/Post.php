<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=[
        'title',
        'location',
        'description',
        'category',
        'user_id',
        'image',
        
    ];

    protected $guarded=[];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
public function reports()
{
    return $this->hasMany(Report::class,'post_id');
}


}
