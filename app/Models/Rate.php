<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable=['user_id','product_id','rate'];

    public function product(){
        return $this->belongsTo(product::class,'product_id');
    }
}
