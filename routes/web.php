<?php

use Illuminate\Support\Facades\Route;
// ルーティングを設定するコントローラを宣言する
use App\Http\Controllers\HelloController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;

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
Route::get('/products', [ProductController::class, 'index']);

// 「/products/1」「/products/10」のようにURLの一部を変化させてその値を取得したい場合は、ルーティングでURLを設定するときにその一部を中括弧{}で囲みます。
// 中括弧{}で囲む文字列は任意に決めて構いませんが、idやproduct_idなど、それが何の値なのかがわかるような文字列にしましょう。
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/vendors/{id}', [VendorController::class, 'show']);