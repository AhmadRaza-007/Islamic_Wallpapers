<?php

use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\WallpaperController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\SurahController;
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

Route::group(['namespace' => 'API'], function () {
    //count number of installs//
    Route::post('userid/{id}', [UserController::class, 'userId']);

    //Public Routes//
    Route::post('/login', [UserController::class, 'postLogin']);
    Route::post('/signup', [UserController::class, 'signup']);
    Route::post('/forget', [UserController::class, 'forgetpassword']);
    Route::post('/changepassword', [UserController::class, 'changepassword']);


    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('category/randomWallpapers', [WallpaperController::class, 'index']);
    Route::get('get-wallpapers-by-category', [WallpaperController::class, 'wallpapersByCategory']);

    Route::get('/detail', [CategoryController::class, 'detail']);

    //Protected Routes//
    Route::group(['middleware' => 'auth:sanctum'], function () {
        ////Begin:Api  Wallpaper Review Routes............///
        Route::get('/get-favroute-wallpapers', [ReviewController::class, 'getFavouritWallpapers']);
        Route::post('/wallpaper_likes', [ReviewController::class, 'likes']);
        Route::post('/wallpaper_dislike', [ReviewController::class, 'dislikes']);
        Route::post('/wallpaper_favourite', [ReviewController::class, 'favourites']);


        ////end:Api  Wallpaper Review Routes............///
        Route::post('/logout', [UserController::class, 'logout']);
        Route::post('/delete_user', [UserController::class, 'deleteUser']);

    });

    Route::get('/books', [BookController::class, 'index']);
    Route::get('/book-with-surah/{id}', [BookController::class, 'book']);

    Route::get('/surah', [SurahController::class, 'index']);
    Route::post('/surah-with-verse/{id}/{lang?}', [SurahController::class, 'surah']);
    Route::get('/verse', [SurahController::class, 'verse']);

});
