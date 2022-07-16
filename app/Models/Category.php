<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title','parent_id'];

    public function parentCategory(){
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function subCategories(){
        return $this->hasMany(Category::class,'parent_Id');
    }

    public function products(){
        return $this->belongsToMany(product::class,'category_product','category_id','product_id');
    }

}
