<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WallpaperController;
use App\Models\Category;
use App\Models\Wallpaper;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

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



//Public Routes//
// Route::get('/aaa', function () {
//     $wallpapers = Wallpaper::inRandomOrder()->get();
//     $categories = Category::get();
//     return view('frontEnd', compact('wallpapers', 'categories'));
//  });
// Route::view('/', 'login')->name('login');
Route::view('login', 'login')->name('login');
Route::get('/clear-cache', function () {
   Artisan::call('cache:clear');
   Artisan::call('route:clear');

   return "Cache cleared successfully";
});
Route::post('login', [UserController::class, 'postLogin'])->name('postLogin');

Route::post('/store-token', [UserController::class, 'updateDeviceToken'])->name('store.token');
//Protected Routes//
Route::group(['middleware' => 'auth'], function() {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard',[UserController::class,'dashboard'])->name('dashboard');

    //Begin:: Category Routes Section//
    Route::get('/categories',[CategoryController::class,'index'])->name('Category');
    Route::post('/Custom-sortable',[CategoryController::class,'updateOrder']);
    Route::post('category/add', [CategoryController::class,'store'])->name('storecategory');
    Route::get('category/edit/{id}', [CategoryController::class,'edit'])->name('showcategory');
    Route::post('category/update', [CategoryController::class,'update'])->name('updatecategory');
    Route::get('category/delete/{id}', [CategoryController::class,'destroy'])->name('deletecategory');
    
    //end:: Category Routes Section//
    Route::get('edit_category/{id}', [WallpaperController::class, 'edit_category']);
    
});
Route::group(['middleware' => 'auth'], function() {
    //Begin:: Category wallpapers Routes Section//
    Route::get('/wall/{id}',[WallpaperController::class,'wall'])->name('wall');
    Route::get('/wallpaper',[WallpaperController::class,'index'])->name('Wallpaper');
    Route::post('/wallpaper/add', [WallpaperController::class, 'store'])->name('Add_Wallpaper');
    Route::get('/wallpaper/edit/{id}', [WallpaperController::class,'edit'])->name('showWallpaper');
    Route::get('/NotifyDetail/edit/{id}', [WallpaperController::class,'NotifyDetail'])->name('NotifyDetail');
    Route::post('wallpaper/update', [WallpaperController::class,'update'])->name('updateWallpaper');
    Route::get('wallpaper/delete/{id}', [WallpaperController::class,'destroy'])->name('deleteWallpaper');
    Route::post('/send-web-notification', [WallpaperController::class, 'sendNotification'])->name('send.web-notification');
});

//                                              FrontEnd Routes
Route::get('/home', [FrontController::class, 'index'])->name('home');
Route::get('/gettingData/{id}', [FrontController::class, 'gettingData'])->name('gettingData');
Route::get('/cat/{id}', [FrontController::class, 'cat'])->name('frontCat');