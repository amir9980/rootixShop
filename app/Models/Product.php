<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','price','old_price','images','status','delete_reason'];
    protected $casts = ['images'=>'array','details'=>'array'];

    public function rates(){
        return $this->hasMany(Rate::class,'product_id');
    }
}
