<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function(){
    Route::get('home',[FileController::class,'index'])->name('files.index');
    Route::get('create',[FileController::class,'create'])->name('files.create');
    Route::post('store',[FileController::class,'store'])->name('files.store');
    
});