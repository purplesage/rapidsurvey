<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyAnswerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Survey;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return redirect('login');
});

Route::get('/dashboard', function () {
  return Inertia::render('Dashboard', ['surveys' => Survey::all()->load('answer')]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  //survey private routes
  Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
  Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
  Route::post('/surveys/store', [SurveyController::class, 'store'])->name('surveys.store');
  Route::get('/surveys/edit/{survey}', [SurveyController::class, 'edit'])->name('surveys.edit');
  Route::put('/surveys/edit/{survey}', [SurveyController::class, 'update'])->name('surveys.update');
  Route::delete('/surveys/{survey}', [SurveyController::class, 'destroy'])->name('surveys.destroy');
  //profile routes
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//public survey route
Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');

//survey answers routes
Route::get('survey_answer/{survey}', [SurveyAnswerController::class, 'create'])->name('survey_answer.create');
Route::post('survey_answer', [SurveyAnswerController::class, 'store'])->name('survey_answer.store');



require __DIR__ . '/auth.php';
