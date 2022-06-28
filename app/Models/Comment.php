<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','status','body','product_id'];

    public function user(){
        return $this->belongsTo(user::class,'user_id');
    }

    public function product(){
        return $this->belongsTo(product::class,'product_id');
    }
}
