<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountToken extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','token','start_date','expire_date','access','percentage'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(user::class,'user_id');
    }

}
