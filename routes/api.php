<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::prefix('v1')->group(function () {
    Route::get('/stocks', [PostController::class, 'index']);
    Route::get('/sales', [PostController::class, 'salesindex']);
    Route::post('/stocks', [PostController::class, 'create']);
    Route::post('/sales', [PostController::class, 'salescreate']);
    Route::get('/stocks/{name}', [PostController::class, 'show']);
    //Route::patch('/posts/update/{id}', [PostController::class, 'update']);
    Route::delete('/stocks', [PostController::class, 'delete']);
});

Route::post('/signup', [PostController::class, 'signup']);
Route::get('/users/{user_id}', [PostController::class, 'getuserid']);
Route::patch('/users/{user_id}', [PostController::class, 'edituser']);
Route::post('/close', [PostController::class, 'close']);


/*
Route::middleware(['middleware' => 'api'])->group(function () {
    # 投稿作成
    Route::post('/posts/create', [App\Http\Controllers\PostController::class, 'create']);
    # 投稿一覧表示
    Route::get('/posts', [App\Http\Controllers\PostController::class, 'index']);
    # 投稿表示
    Route::get('/posts/{name}', [App\Http\Controllers\PostController::class, 'show']);
    # 投稿編集
    Route::patch('/posts/update/{id}' , [App\Http\Controllers\PostController::class, 'update']);
    # 投稿削除
    Route::delete('/posts/{id}', [App\Http\Controllers\PostController::class, 'delete']);
});


/*
Route::middleware(['middleware' => 'api'])->group(function () {
    # 投稿作成
    Route::post('/posts/create', 'PostController@create');
    # 投稿一覧表示
    Route::get('/posts', 'PostController@index');
    # 投稿表示
    Route::get('/posts/{id}', 'PostController@show');
    # 投稿編集
    Route::patch('/posts/update/{id}' , 'PostController@update');
    # 投稿削除
    Route::delete('/posts/{id}', 'PostController@delete');
});
*/