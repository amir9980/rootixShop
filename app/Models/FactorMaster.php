<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factorMaster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','discount_token_id','user_first_name','user_last_name','payment_method','state','city','address','is_paid','total_price'];

    public function user(){
        return $this->belongsTo(user::class,'user_id','id');
    }

    public function details(){
        return $this->hasMany(factorDetail::class,'master_id');
    }

    public function reports(){
        return $this->morphMany(PaymentReport::class,'reportable');
    }

    public function discountToken(){
        return $this->belongsTo(DiscountToken::class,'discount_token_id');
    }
}
