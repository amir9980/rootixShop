<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderShipping extends Model
{
    use HasFactory;

    protected $fillable = ['factor_id','type','description','extra_field'];

    public function factor(){
        return $this->belongsTo(factorMaster::class,'factor_id');
    }
}
