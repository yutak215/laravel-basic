<?php

use Illuminate\Support\Facades\Route;
// ルーティングを設定するコントローラを宣言する
use App\Http\Controllers\HelloController;

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

Route::get('/', function () {
    return view('welcome');
});
// そのURLにアクセスしたときに実行する処理」をルーティングに直接記述する代わりに、HelloControllerのindexアクションを指定しました。
// Route::HTTPリクエストメソッド名('URL', [コントローラ名::class, 'アクション名']);

Route::get('/hello', [HelloController::class, 'index']);