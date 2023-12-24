<?php

use App\Http\Controllers\API\CommentController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//regist
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [LoginController::class, 'login']);

Route::get('/userfree', [LoginController::class, 'userfree']);

Route::get('/posts', [PostController::class, 'index'])->middleware('auth:api'); // show all post
Route::get('/posts-by/{id_user}', [PostController::class, 'showBy'])->middleware('auth:api'); // show all post
Route::get('/posts/{id}', [PostController::class, 'show'])->middleware('auth:api'); //detail
Route::post('/posts', [PostController::class, 'store'])->middleware('auth:api'); //insert
Route::post('/posts/{id}', [PostController::class, 'update'])->middleware('auth:api'); //update
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('auth:api'); //delete
Route::post('/posts-like', [PostController::class, 'like'])->middleware('auth:api'); //add post LIKE
Route::post('/posts-dislike', [PostController::class, 'dislike'])->middleware('auth:api'); //add post LIKE

//Comment
Route::post('/comment-add', [CommentController::class, 'add_comment'])->middleware('auth:api'); //add comment

Route::post('/comment-like', [CommentController::class, 'like_comment'])->middleware('auth:api'); //like_comment
Route::post('/comment-dislike', [CommentController::class, 'dislike_comment'])->middleware('auth:api'); //dislike_comment

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api'); //logout

