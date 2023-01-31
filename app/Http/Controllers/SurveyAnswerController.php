<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Survey_answer;
use Inertia\Inertia;
use Illuminate\Validation\Rule as ValidationRule;


class SurveyAnswerController extends Controller
{
  public function create(Survey $survey)
  {
    return Inertia::render('Answers/Answer_create', ['survey' => $survey]);
  }

  public function store(Request $request)
  {
    $request->validate([
      'survey_id' => [ValidationRule::exists('surveys', 'id')],
      'formData.*.answer' => ['max:150'],
    ]);

    Survey_answer::create(['survey_id' => $request['survey_id'], 'answers' => json_encode($request['formData'])]);

    return Inertia::render('Answers/Succsessful')->with('sucess', 'Answer submited!');
  }
}
