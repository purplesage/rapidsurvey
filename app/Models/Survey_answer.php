<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Survey;

class Survey_answer extends Model
{
  use HasFactory;

  protected $fillable = ['survey_id', 'answers'];

  public function survey()
  {
    return $this->belongsTo(Survey::class);
  }
}
