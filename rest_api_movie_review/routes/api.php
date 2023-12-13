<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;

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

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('reviewer', [ReviewerController::class, 'index']);
    Route::post('reviewer', [ReviewerController::class, 'create']);
    Route::get('reviewer/{id}', [ReviewerController::class, 'show']);
    Route::get('reviewer', [ReviewerController::class, 'search']);
    Route::put('reviewer/{reviewer}', [ReviewerController::class, 'update']);
    Route::delete('reviewer/{reviewer}', [ReviewerController::class, 'destroy']);

    Route::get('movies', [MovieController::class, 'index']);
    Route::post('movie', [MovieController::class, 'create']);
    Route::get('movie/{id}', [MovieController::class, 'show']);
    Route::get('movie', [MovieController::class, 'search']);
    Route::put('movie/{movie}', [MovieController::class, 'update']);
    Route::delete('movie/{movie}', [MovieController::class, 'destroy']);

    Route::get('review', [ReviewController::class, 'index']);
    Route::post('review', [ReviewController::class, 'create']);
    Route::get('review/{id}', [ReviewController::class, 'show']);
    Route::put('review/{review}', [ReviewController::class, 'update']);
    Route::get('review', [ReviewController::class, 'search']);
    //Route::get('review/searchByBook/{book_id}', [ReviewController::class, 'searchByBookId']);
    //Route::get('review/searchByReviewer/{reviewer_id}', [ReviewController::class, 'searchByReviewerId']);
    Route::delete('review/{review}', [ReviewController::class, 'destroy']);

    Route::post('logout', [AuthController::class, 'logout']);
});
