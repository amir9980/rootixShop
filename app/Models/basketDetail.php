<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class basketDetail extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','count','master_id'];
    protected $table = 'baskets_details';

    public function master(){
        return $this->belongsTo(basket::class,'master_id');
    }
    public function product(){
        return $this->belongsTo(product::class,'product_id');
    }
}
