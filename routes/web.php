<?php

use Illuminate\Support\Facades\Route;
// use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BooksController;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//本ダッシュボード表示(books.blade.php)
Route::get('/', [BooksController::class, 'index']);

//登録処理
Route::post('/books', [BooksController::class, 'store']);

//更新画面
Route::post('/booksedit/{books}', [BooksController::class, 'edit']);

//更新処理
Route::post('/books/update', [BooksController::class, 'update']);

// 本を削除
Route::delete('/book/{book}', [BooksController::class, 'destroy']);

// Auth
Auth::routes();
// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/home', [BooksController::class, 'index'])->name('home'); //HomeController::classから変更

//Route::groupを使ったログイン認証 ※BooksControllerの「construct()」を使う場合は、こちらは使用しない
// Route::group(['middleware' => 'auth'], function () {
//     //welcomeページを表示
//     Route::get("/",function(){
//       return view("welcome");
//     });
//  });