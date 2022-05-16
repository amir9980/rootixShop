<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{

    protected $fillable = ['username', 'password', 'email', 'is_admin'];


    public function productsInCart()
    {
        return $this->belongsToMany(product::class, 'carts', 'user_id', 'product_id');
    }

    public function cart()
    {
        return $this->hasMany(cart::class, 'user_id');
    }

    public function factors()
    {
        return $this->hasMany(factorMaster::class, 'user_id', 'id');
    }
}
