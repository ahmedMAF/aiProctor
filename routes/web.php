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

Route::get('/teacher/add' , [AddExamController::class , 'add'])->middleware('auth');
Route::post('/teacher/add' , [AddExamController::class , 'addExam'])->middleware('auth');
Route::get('/teacher/students/{id}' , [AddExamController::class , 'students'])->middleware('auth');
Route::get('/teacher/students/report/{studentId}/{examId}' , [AddExamController::class , 'report'])->middleware('auth');
Route::get('/teacher/students/retry/{student}/{studentId}/{examId}' , [AddExamController::class , 'retry'])->middleware('auth');
Route::get('/teacher/update/{examId}' , [AddExamController::class , 'updateExam'])->middleware('auth');
Route::put('/teacher/update/{examId}' , [AddExamController::class , 'update'])->middleware('auth');
Route::delete('/teacher/delete/{examId}' , [AddExamController::class , 'delete'])->middleware('auth');

Route::get('/teacher/addQ/{id}' , [AddQController::class , 'questions'])->middleware('auth');
Route::post('/teacher/addQ/{id}' , [AddQController::class , 'add'])->middleware('auth');
Route::delete('/teacher/deleteQ/{id}/{examId}' , [AddQController::class , 'delete'])->middleware('auth');
Route::get('/teacher/editQ/{q}' , [AddQController::class , 'edit'])->middleware('auth');
Route::put('/teacher/editQ/{q}' , [AddQController::class , 'editQ'])->middleware('auth');

Route::get('/student/examlink/{id}' , [ExamController::class , 'verification'])->middleware('auth');
Route::get('/student/exam/{id}' , [ExamController::class , 'takeExam'])->middleware('auth');
Route::POST('/exam/next-question/{id}' , [ExamController::class , 'nextQuestion'])->middleware('auth');
Route::POST('/exam/finish/{id}' , [ExamController::class , 'finish'])->middleware('auth');
Route::get('/exam/next-question/refresh/{id}' , [ExamController::class , 'refresh'])->middleware('auth');

Route::post('/exam/report/{examId}' , [ExamController::class , 'report'])->middleware('auth');

Route::get('/student/review/{id}' , [StudentController::class , 'review'])->middleware('auth');

require __DIR__.'/auth.php';
