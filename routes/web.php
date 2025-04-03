<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddExamController;
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

require __DIR__.'/auth.php';
