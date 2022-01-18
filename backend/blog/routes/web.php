<?php

use App\Http\Controllers\Admin\ArticlesManagerController;
use App\Http\Controllers\Admin\CategoriesManagerController;
use App\Http\Controllers\Admin\TagManagerController;
use App\Http\Controllers\Admin\UsersManagerController;
use App\Http\Controllers\Admin\CommentManagerController;
use App\Http\Controllers\HomeController;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RateManagerController;
use App\Http\Controllers\Auth\SocicalController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/',function() {
    return redirect('/admin/dashboard');
});
Route::group(['prefix' => 'admin','middleware' => ['auth']],function() {
    Route::get('/dashboard',[UsersManagerController::class,'dashboardAdmin'])->name('adminDashboard');
    Route::get('/users',[UsersManagerController::class,'listUsers'])->name('adminUsers');
    Route::resource('/article', ArticlesManagerController::class);
    Route::resource('/category', CategoriesManagerController::class);
    Route::resource('/tag_admin', TagManagerController::class);
    Route::resource('/comment', CommentManagerController::class);
    Route::resource('/rate', RateManagerController::class);
    Route::post('/blocked/{user}',[UsersManagerController::class,'blocked'])->name('blocked');
    Route::post('/accept/article/{article}',[ArticlesManagerController::class,'acceptArticle'])->name('acceptArticle');

});
Auth::routes();


