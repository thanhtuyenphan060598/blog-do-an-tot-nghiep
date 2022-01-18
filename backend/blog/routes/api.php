<?php

use App\Http\Controllers\ApiUserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\OutController;
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
Route::post('sociallogin/{provider}',[AuthController::class,'SocialSignup']);
Route::get('auth/{provider}/callback',[OutController::class,'index'])->where('provider', '.*');


Route::resource('/articles', ArticleController::class);
Route::resource('/categories', CategoryController::class);
Route::resource('/tag', TagController::class);



Route::post('/register',[ApiUserController::class,'register']);
Route::post('/login',[ApiUserController::class,'login']);
Route::post('/logout',[ApiUserController::class,'logout']);

Route::post('/comment/delete/{comment}',[ApiUserController::class,'commentDelete']);
Route::post('/comment/edit/{comment}',[ApiUserController::class,'commentEdit']);
Route::post('/delete/like/{user}',[ApiUserController::class,'deleteLike']);
Route::post('/upload/img/{user}',[ApiUserController::class,'uploadImg']);


Route::get('/review/rate/{article}',[ApiUserController::class,'reviewGet']);
Route::get('/articles/user/{user}',[ApiUserController::class,'userArticle']);
Route::get('/view/post',[ApiUserController::class,'getPostView']);


Route::group(['middleware'=>['auth:sanctum']],function() {


    Route::put('/articles/view/{article}',[ArticleController::class,'updateView']);

    Route::get('/comments/{article}',[ApiUserController::class,'comments']);
    Route::get('/comments/feedback/{comment}',[ApiUserController::class,'getCommentFeedbacks']);
    Route::get('/comment/num/{article}',[ApiUserController::class,'commentGet']);
    Route::get('/information/{id}',[ApiUserController::class,'getInfo']);
    Route::get('/information/{id}',[ApiUserController::class,'getInfo']);
    Route::get('/user/check/{user}',[ApiUserController::class,'checkUser']);
    Route::get('/user/like',[ApiUserController::class,'userLike']);


    Route::post('/information',[ApiUserController::class,'information']);
    Route::post('/password/{user}',[ApiUserController::class,'password']);
    Route::post('/comment/{article}',[ApiUserController::class,'comment']);
    Route::post('/review',[ApiUserController::class,'review']);
    Route::post('/comment/feedback/{comment}',[ApiUserController::class,'commentFeedback']);


});
