<?php

use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\FrontController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerseController;
use App\Http\Controllers\WallpaperController;
use App\Models\Book;
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
Route::group(['middleware' => 'auth'], function () {
    Route::post('logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    //Begin:: Category Routes Section//
    Route::get('/categories', [CategoryController::class, 'index'])->name('Category');
    Route::post('/Custom-sortable', [CategoryController::class, 'updateOrder']);
    Route::post('category/add', [CategoryController::class, 'store'])->name('storecategory');
    Route::get('category/edit/{id}', [CategoryController::class, 'edit'])->name('showcategory');
    Route::post('category/update', [CategoryController::class, 'update'])->name('updatecategory');
    Route::get('category/delete/{id}', [CategoryController::class, 'destroy'])->name('deletecategory');
    //end:: Category Routes Section//
    Route::get('edit_category/{id}', [WallpaperController::class, 'edit_category']);
});
Route::group(['middleware' => 'auth'], function () {
    //Begin:: Category wallpapers Routes Section//
    Route::get('/wall/{id}', [WallpaperController::class, 'wall'])->name('wall');
    Route::get('/wallpaper', [WallpaperController::class, 'index'])->name('Wallpaper');
    Route::post('/wallpaper/add', [WallpaperController::class, 'store'])->name('Add_Wallpaper');
    Route::get('/wallpaper/edit/{id}', [WallpaperController::class, 'edit'])->name('showWallpaper');
    Route::get('/NotifyDetail/edit/{id}', [WallpaperController::class, 'NotifyDetail'])->name('NotifyDetail');
    Route::post('wallpaper/update', [WallpaperController::class, 'update'])->name('updateWallpaper');
    Route::get('wallpaper/delete/{id}', [WallpaperController::class, 'destroy'])->name('deleteWallpaper');
    Route::post('/send-web-notification', [WallpaperController::class, 'sendNotification'])->name('send.web-notification');

    // Route::post('/verse/add', [SurahController::class, 'store'])->name('Add_Verse');
});

//                                              FrontEnd Routes
// Route::get('/home', [FrontController::class, 'index'])->name('home');
// Route::get('/gettingData/{id}', [FrontController::class, 'gettingData'])->name('gettingData');
// Route::get('/cat/{id}', [FrontController::class, 'cat'])->name('frontCat');


// Route::group(['middleware' => 'auth'], function () {
    Route::get('/books', [BooksController::class, 'index'])->name('books');
    Route::get('/book/{id}', [BooksController::class, 'book'])->name('bookId');
    Route::post('book/add', [BooksController::class, 'store'])->name('storebook');
    Route::get('book/edit/{id}', [BooksController::class, 'edit'])->name('showbook');
    Route::post('book/update', [BooksController::class, 'update'])->name('updatebook');
    Route::get('book/delete/{id}', [BooksController::class, 'destroy'])->name('deletebook');

    Route::get('/surah', [SurahController::class, 'index'])->name('surah');
    Route::get('/surah/{id}', [SurahController::class, 'surah'])->name('surahId');
    Route::post('surah/add', [SurahController::class, 'store'])->name('storesurah');
    Route::get('surah/edit/{id}', [SurahController::class, 'edit'])->name('showsurah');
    Route::post('surah/update', [SurahController::class, 'update'])->name('updatesurah');
    Route::get('surah/delete/{id}', [SurahController::class, 'destroy'])->name('deletesurah');

    Route::get('/verse', [VerseController::class, 'index'])->name('verse');
    Route::get('verse/edit/{id}', [VerseController::class, 'edit'])->name('showverse');
    Route::get('/verse/{id}/{num?}', [VerseController::class, 'verse'])->name('verseId')->where('id', '[0-9]+');
    Route::post('verse/add', [VerseController::class, 'store'])->name('storeverse');
    Route::post('verse/update', [VerseController::class, 'update'])->name('updateverse');
    Route::get('verse/delete/{id}', [VerseController::class, 'destroy'])->name('deleteverse');

    Route::get('/languages', [LanguagesController::class, 'index'])->name('languages');
    Route::post('language/add', [LanguagesController::class, 'store'])->name('storelanguage');
    Route::get('language/edit/{id}', [LanguagesController::class, 'edit'])->name('showlanguage');
    Route::post('language/update', [LanguagesController::class, 'update'])->name('updatelanguage');
    Route::get('language/delete/{id}', [LanguagesController::class, 'destroy'])->name('deletelanguage');
// });
