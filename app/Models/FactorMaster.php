<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factorMaster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','is_paid','total_price','shop'];

    public function user(){
        return $this->belongsTo(user::class,'user_id','id');
    }

    public function details(){
        return $this->hasMany(factorDetail::class,'master_id');
    }

    public function reports(){
        return $this->morphMany(PaymentReport::class,'reportable');
    }
}
