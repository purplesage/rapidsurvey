<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule as ValidationRule;


class SurveyController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return Inertia::render('Surveys/Index', ['surveys' => Survey::all()]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return Inertia::render('Surveys/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $attributes = $request->validate([
      'title' => ['required', 'min:20', ValidationRule::unique('surveys', 'title')],
      'description' => 'required|max:350|min:10',
      'thumbnail' => 'required|image',
      'expire_date' => 'date|after:today',
      'is_active' => 'required',
      'questionList' => 'required|array'
    ]);

    $request->user()->surveys()->create([
      ...$attributes,
      'thumbnail' => request()->file('thumbnail')->store('thumbnails'),
      'questionList' => json_encode($request['questionList'])
    ]);

    return to_route('surveys.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Survey  $survey
   * @return \Illuminate\Http\Response
   */
  public function show(Survey $survey)
  {
    return Inertia::render('Surveys/Show', ['survey' => $survey]);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Survey  $survey
   * @return \Illuminate\Http\Response
   */
  public function edit(Survey $survey)
  {
    return Inertia::render('Surveys/Edit', ['survey' => $survey]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Survey  $survey
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Survey $survey)
  {
    $attributes = $request->validate([
      'title' => ['required', "min:20", ValidationRule::unique('surveys', 'title')->ignore($survey->id)],
      'description' => 'required|max:350|min:10',
      'thumbnail' => 'required|image',
      'expire_date' => 'date|after:today',
      'is_active' => 'required',
      'questionList' => 'required|array'
    ]);

    if (isset($attributes['thumbnail'])) {
      $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
    }

    $survey->update([
      ...$attributes,
      'questionList' => json_encode($request['questionList'])
    ]);

    return to_route('surveys.index')->with('success', 'survey has been edited');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Survey  $survey
   * @return \Illuminate\Http\Response
   */
  public function destroy(Survey $survey)
  {
    $survey->delete();

    return to_route('surveys.index')->with('success', 'survey has been deleted');
  }
}
