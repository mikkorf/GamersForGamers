<?php

use App\Models\ReviewCategory;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewPostController;
use App\Http\Controllers\ExperiencePostController;
use App\Http\Controllers\TipPostController;
use App\Http\Controllers\NewsPostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EditProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the 'web' middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/reviewPosts/checkSlug', [ReviewPostController::class, 'checkSlug']);
Route::resource('/reviewPosts', ReviewPostController::class);
Route::get('/reviewPosts/{reviewPost:slug}/getAllComment', [ReviewPostController::class, 'getAllComment']);
Route::post('/reviewPosts/{reviewPost:slug}/storeComment', [ReviewPostController::class, 'storeComment']);
Route::post('/reviewPosts/{reviewPost:slug}/updateComment', [ReviewPostController::class, 'updateComment']);
Route::post('/reviewPosts/{reviewPost:slug}/destroyComment', [ReviewPostController::class, 'destroyComment']);
Route::get('/reviewPosts/{reviewPost:slug}/getAllLike', [ReviewPostController::class, 'getAllLike']);
Route::post('/reviewPosts/{reviewPost:slug}/storeLike', [ReviewPostController::class, 'storeLike']);
Route::post('/reviewPosts/{reviewPost:slug}/destroyLike', [ReviewPostController::class, 'destroyLike']);

Route::get('/tipPosts/checkSlug', [TipPostController::class, 'checkSlug']);
Route::resource('/tipPosts', TipPostController::class);
Route::get('/tipPosts/{tipPost:slug}/getAllComment', [TipPostController::class, 'getAllComment']);
Route::post('/tipPosts/{tipPost:slug}/storeComment', [TipPostController::class, 'storeComment']);
Route::post('/tipPosts/{tipPost:slug}/updateComment', [TipPostController::class, 'updateComment']);
Route::post('/tipPosts/{tipPost:slug}/destroyComment', [TipPostController::class, 'destroyComment']);
Route::get('/tipPosts/{tipPost:slug}/getAllLike', [TipPostController::class, 'getAllLike']);
Route::post('/tipPosts/{tipPost:slug}/storeLike', [TipPostController::class, 'storeLike']);
Route::post('/tipPosts/{tipPost:slug}/destroyLike', [TipPostController::class, 'destroyLike']);
 
Route::get('/newsPosts/checkSlug', [NewsPostController::class, 'checkSlug']);
Route::resource('/newsPosts', NewsPostController::class);
Route::get('/newsPosts/{newsPost:slug}/getAllComment', [NewsPostController::class, 'getAllComment']);
Route::post('/newsPosts/{newsPost:slug}/storeComment', [NewsPostController::class, 'storeComment']);
Route::post('/newsPosts/{newsPost:slug}/updateComment', [NewsPostController::class, 'updateComment']);
Route::post('/newsPosts/{newsPost:slug}/destroyComment', [NewsPostController::class, 'destroyComment']);
Route::get('/newsPosts/{newsPost:slug}/getAllLike', [NewsPostController::class, 'getAllLike']);
Route::post('/newsPosts/{newsPost:slug}/storeLike', [NewsPostController::class, 'storeLike']);
Route::post('/newsPosts/{newsPost:slug}/destroyLike', [NewsPostController::class, 'destroyLike']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/editProfile', [EditProfileController::class, 'index'])->middleware('auth');
Route::post('/editProfile/update', [EditProfileController::class, 'update'])->middleware('auth');