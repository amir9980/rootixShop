<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class user extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['username', 'password', 'email', 'is_admin','profile_pic'];


    public function productsInCart()
    {
        return $this->belongsToMany(product::class, 'carts', 'user_id', 'product_id');
    }

    public function addresses(){
        return $this->hasMany(Address::class,'user_id');
    }

    public function cart()
    {
        return $this->hasMany(cart::class, 'user_id');
    }

    public function factors()
    {
        return $this->hasMany(factorMaster::class, 'user_id', 'id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'user_id');
    }

    public function bookmarks(){
        return $this->belongsToMany(product::class,'bookmarks','user_id','product_id');
    }

    public function orderShipping(){
        return $this->hasOne(OrderShipping::class,'user_id');
    }

}
