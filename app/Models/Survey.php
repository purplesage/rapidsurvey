<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Survey_answer;

class Survey extends Model
{
  use HasFactory;

  protected $fillable = [
    'title',
    'description',
    'user_id',
    'thumbnail',
    'expire_date',
    'is_active',
    'questionList'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  function answers()
  {
    return $this->hasMany(Survey_answer::class);
  }
}
