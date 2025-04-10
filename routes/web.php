<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddExamController;
use App\Http\Controllers\AddQController;
use App\Http\Controllers\ExamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/teacher/add' , [AddExamController::class , 'add']);
Route::post('/teacher/add' , [AddExamController::class , 'addExam']);

Route::get('/teacher/addQ/{id}' , [AddQController::class , 'questions']);
Route::post('/teacher/addQ/{id}' , [AddQController::class , 'add']);

Route::get('/student/examlink/{id}' , [ExamController::class , 'verification']);
Route::get('/student/exam/{id}' , [ExamController::class , 'takeExam']);
Route::get('/exam/next-question/{id}' , [ExamController::class , 'nextQuestion']);

require __DIR__.'/auth.php';
