<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use Inertia\Inertia;

class SurveyAnswerController extends Controller
{
  public function create(Survey $survey)
  {
    return Inertia::render('Answers/Answer_create', ['survey' => $survey]);
  }

  public function store(Request $request)
  {
    dd($request->all());
  }
}
