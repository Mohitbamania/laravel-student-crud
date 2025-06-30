<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentDetailsController;

Route::get('/', function () {
    return view('welcome');
});

// Student Routes

Route::get('student', [StudentDetailsController::class, 'index'])->name('student.index');
Route::post('student/store', [StudentDetailsController::class, 'store'])->name('student.store');
Route::post('student/update', [StudentDetailsController::class, 'update'])->name('student.update');
Route::post('student/delete', [StudentDetailsController::class, 'delete'])->name('student.delete');

