<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
 use App\Models\Product;

class CookieController extends Controller
{
// 流れ
// １、/cookies（index.blade.phpとルーティングで紐付け）でindexメソッド呼び出し→空なので商品選択→create.blade.php
// 2,create.blade.php全商品から選択→「カートに入れる」でstoreメソッド呼び出し→/cookies(index.blade.php)が返される→ポチられた商品が表示
// ３、cookieを使用しているので、ブラウザを閉じても一定期間,ポチられた商品が情報として保存される

    // １クッキーから商品ID (product_id) を取得し、その商品情報を表示する (index メソッド)
    public function index() {
        // クッキーから'product_id'キーの値を取得する
        $product_id = Cookie::get('product_id');
        // 取得した product_id に該当する商品をデータベースから取得する
        $product = Product::find($product_id);
        // 取得した商品情報をビューに渡し、表示する
        return view('cookies.index', compact('product'));
    }

    // ２商品の選択画面を表示する (create メソッド)
    public function create() {
        // Product::all() によって、データベースから全商品を取得
        $products = Product::all();

        return view('cookies.create', compact('products'));
    }

    // ３商品IDをクッキーに保存する (store メソッド)
    public function store(Request $request) {
        // バリデーション: 'product_id' が必須かつ products テーブルに存在することを確認する
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // キー名が'product_id'、値が商品IDのデータをクッキーに設定する（60分有効）
        Cookie::queue('product_id', $request->input('product_id'), 60);

        // HTTPレスポンスと同時にクッキーが送信される
        return redirect('/cookies');
    }

    // ４クッキーから商品IDを削除する (destroy メソッド)
    public function destroy() {
        // クッキーから'product_id'キーとその値を削除するように設定する
        Cookie::queue(Cookie::forget('product_id'));

        // HTTPレスポンスの送信と同時にクッキーが削除される
        return redirect('/cookies');
    }
}
