<?php

use App\Http\Controllers\PracticeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SheetController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\ScheduleController;
use Illuminate\Support\Facades\Route;

// Route::get('URL', [Controllerの名前::class, 'Controller内のfunction名']);
Route::get('/movies',[MovieController::class,'index'])->name('movies.index');
Route::get('/practice', [PracticeController::class, 'sample']);
Route::get('/practice2', [PracticeController::class, 'sample2']);
Route::get('/practice3',[PracticeController::class,'sample3']);
Route::get('/getPractice',[PracticeController::class,'getPractice']);
Route::get('/sheets',[SheetController::class,'index']);
Route::get('/movies/{id}',[MovieController::class,'show'])->name('movies.show');


Route::prefix('admin')->group(function(){
    Route::get('/movies', [AdminMovieController::class, 'index'])->name('admin.movies.index');
    Route::get('/movies/create', [AdminMovieController::class, 'create'])->name('admin.movies.create');
    Route::post('/movies/store', [AdminMovieController::class, 'store'])->name('admin.movies.store');
    Route::get('/movies/{id}', [AdminMovieController::class, 'show'])->name('admin.movies.show');
    Route::get('/movies/{id}/edit', [AdminMovieController::class, 'edit'])->name('admin.movies.edit');
    Route::patch('/movies/{id}/update', [AdminMovieController::class, 'update'])->name('admin.movies.update');
    Route::delete('/movies/{id}/destroy', [AdminMovieController::class, 'destroy'])->name('admin.movies.destroy');
    
    Route::get('/schedules', [ScheduleController::class, 'index'])->name('admin.schedules.index');
    Route::get('/schedules/{id}', [ScheduleController::class, 'show'])->name('admin.schedules.show');
    Route::get('/movies/{id}/schedules/create',[ScheduleController::class,'create'])->name('admin.schedules.create');
    Route::post('/movies/{id}/schedules/store',[ScheduleController::class,'store'])->name('admin.schedules.store');
    Route::get('/schedules/{scheduleId}/edit',[ScheduleController::class,'edit'])->name('admin.schedules.edit');
    Route::patch('/schedules/{id}/update',[ScheduleController::class,'update'])->name('admin.schedules.update');
    Route::delete('/schedules/{id}/destroy',[ScheduleController::class,'destroy'])->name('admin.schedules.destroy');


});

