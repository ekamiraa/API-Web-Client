<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReviewerController;
use App\Http\Controllers\BookController;
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

    Route::get('book', [BookController::class, 'index']);
    Route::post('book', [BookController::class, 'create']);
    Route::get('book/{id}', [BookController::class, 'show']);
    Route::get('book', [BookController::class, 'search']);
    Route::put('book/{book}', [BookController::class, 'update']);
    Route::delete('book/{book}', [BookController::class, 'destroy']);

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