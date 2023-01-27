<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Survey extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'user_id',
    'thumbnail',
    'expire_date'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
