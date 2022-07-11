<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factorMaster extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','discount_token_id','tracking_code','address_id','payment_method','state','city','address','is_paid','total_price'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
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

    public function discountEvent(){
        return $this->belongsTo(DiscountEvent::class,'discount_event_id');
    }

    public function address(){
        return $this->belongsTo(Address::class,'address_id');
    }

    public function orderShipping(){
        return $this->hasMany(OrderShipping::class,'factor_id');
    }
}
