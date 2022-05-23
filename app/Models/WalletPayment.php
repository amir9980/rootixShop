<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletPayment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','value','doorway'];

    public function user(){
        return $this->belongsTo(user::class,'user_id');
    }

    public function reports(){
        return $this->morphMany(PaymentReport::class,'reportable');
    }
}
