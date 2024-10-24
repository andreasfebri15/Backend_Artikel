<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

route::post('login', [AuthController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['prefix' => 'article'], function () {

        Route::post('/add', [ArticleController::class, 'store']);
        Route::post('/update', [ArticleController::class, 'update']);
        Route::delete('/delete', [ArticleController::class, 'delete']);
    });

    Route::group(['prefix' => 'comment'], function () {
        Route::get('/', [CommentController::class, 'index']);
        Route::post('/add', [CommentController::class, 'store']);
    });
});
Route::group(['prefix' => 'article'], function () {
    Route::get('/', [ArticleController::class, 'index']);
});
