<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class factorDetail extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','count','master_id'];

    public function master(){
        return $this->belongsTo(factorMaster::class,'master_id');
    }
    public function product(){
        return $this->belongsTo(product::class,'product_id');
    }
}
