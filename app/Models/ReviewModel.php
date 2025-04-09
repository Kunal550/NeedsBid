<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewModel extends Model
{
  protected $guarded = [];
  use HasFactory;

  public function review_to_user()
  {

    return $this->hasOne('App\Models\User', 'id', 'user_id');
  }
}
