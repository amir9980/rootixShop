<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class basket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','is_paid','total_price','shop'];
    protected $table = 'baskets_master';

    public function user(){
        return $this->belongsTo(user::class,'user_id','id');
    }

    public function details(){
        return $this->hasMany(basketDetail::class,'master_id');
    }
}
