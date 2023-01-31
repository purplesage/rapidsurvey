<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\SurveyAnswerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
  return Inertia::render('Dashboard');
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

Route::get('survey_answer/{survey}', [SurveyAnswerController::class, 'create'])->name('survey_answer.create');


require __DIR__ . '/auth.php';
