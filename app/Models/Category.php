<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar','category'];
    public function getAvatarAttribute (){
        if (array_key_exists('category_image', $this->attributes) && (!empty($this->attributes['category_image']))) {
            return asset('public/uploads/category/'.$this->attributes['category_image']);
        } else {
            return asset('public/uploads/category/noimg.png');
        }
    }

    public function getCategoryAttribute (){
        if (array_key_exists('category_banner_image', $this->attributes) && (!empty($this->attributes['category_banner_image']))) {
            return asset('public/uploads/category_banner/'.$this->attributes['category_banner_image']);
        } else {
            return asset('public/uploads/category_banner/noimg.png');
        }
    }
    public function immediateParentName()
    {
        return $this->belongsTo(Category::class, 'parent');
    }
    
    public function category_to_product()
    {
        return $this->hasOne('App\Models\Product','category_id','id');
    }
    public function sub_category_to_product()
    {
        return $this->hasOne('App\Models\Product','sub_category_id','id');
    }
    
    
}
