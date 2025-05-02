<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddExamController;
use App\Http\Controllers\AddQController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
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
Route::get('/teacher/students/{id}' , [AddExamController::class , 'students']);
Route::get('/teacher/students/report/{studentId}/{examId}' , [AddExamController::class , 'report']);
Route::get('/teacher/update/{examId}' , [AddExamController::class , 'updateExam']);
Route::put('/teacher/update/{examId}' , [AddExamController::class , 'update']);

Route::get('/teacher/addQ/{id}' , [AddQController::class , 'questions']);
Route::post('/teacher/addQ/{id}' , [AddQController::class , 'add']);

Route::get('/student/examlink/{id}' , [ExamController::class , 'verification']);
Route::get('/student/exam/{id}' , [ExamController::class , 'takeExam']);
Route::POST('/exam/next-question/{id}' , [ExamController::class , 'nextQuestion']);
Route::POST('/exam/finish/{id}' , [ExamController::class , 'finish']);
Route::get('/exam/next-question/refresh/{id}' , [ExamController::class , 'refresh']);

Route::get('/student/review/{id}' , [StudentController::class , 'review']);

require __DIR__.'/auth.php';
