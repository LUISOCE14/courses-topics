<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseTopicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/courses-topics', [CourseTopicController::class, 'store']); //guarda un curso
Route::put('/courses-topics/{id}', [CourseTopicController::class, 'update']); //actualiza un curso
Route::delete('/courses-topics/{id}', [CourseTopicController::class, 'destroy']); //elimina un curso