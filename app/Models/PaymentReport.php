<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReport extends Model
{
    use HasFactory;

    protected $fillable = ['status','type','value','log','reportable_type','reportable_id'];

    public function reportable(){
        return $this->morphTo();
    }
}
