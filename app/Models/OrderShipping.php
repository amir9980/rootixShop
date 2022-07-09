<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    use HasFactory;

    protected $fillable = ['factor_id','status','ordered_description','checked_description','sent_description','delivered_description','tracking_code','postal_tracking_code'];

    public function factor(){
        return $this->belongsTo(factorMaster::class,'factor_id');
    }
}
