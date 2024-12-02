<?php

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3',[PracticeController::class,'sample3']);
Route::get('/getPractice',[PracticeController::class,'getPractice']);
Route::get('/movies',[MovieController::class,'index']);
Route::prefix('admin')->group(function(){
    Route::get('/movies',[AdminMovieController::class,'index']);
    Route::get('/movies/{id}',[AdminMovieController::class,'show']);
});

