<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;

    protected $fillable=['product_id','user_id','count'];

    public function product(){
        return $this->belongsTo(product::class,'product_id');
    }
}
