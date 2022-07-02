<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','price','old_price','thumbnail','status','delete_reason'];
    protected $casts = ['details'=>'array'];

    public function rates(){
        return $this->hasMany(Rate::class,'product_id');
    }

    public function images(){
        return $this->hasMany(FileUpload::class,'product_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'product_id');
    }

    public function bookmarks(){
        return $this->belongsToMany(User::class,'bookmarks','product_id','user_id');
    }
}
