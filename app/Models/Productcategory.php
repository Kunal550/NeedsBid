<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productcategory extends Model
{
  use HasFactory;
  protected $guarded = [];
  protected $table = 'productcategories';

  public function productcategory_to_product()
  {
    return $this->hasMany('App\Models\Product', 'productcategory_id', 'id');
  }
}
