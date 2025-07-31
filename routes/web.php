<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;


Route::get('/', [ViewController::class, 'index'])->name('home');

Route::group(['prefix' => 'course-topics', 'as' => 'course-topics.'], function () {
    Route::get('/', [ViewController::class, 'index'])->name('index'); //trae todos los temas de curso
    Route::get('create', [ViewController::class, 'create'])->name('create'); //trae vista de crear curso
    Route::get('/{id}/edit', [ViewController::class, 'edit'])->name('edit'); //trae vista de editar curso
});


