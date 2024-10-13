<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class ProductController extends Controller
{
    //追加
    public function index() {
        // productsテーブルからすべてのデータを取得し、変数$productsに代入する
        $products = DB::table('products')->get();

        // 変数$productsをproducts/index.blade.phpファイルに渡す
        // 第一引数はフォルダの場所、変数の名前ではない
        return view('products.index', compact('products'));
    }

    public function show($id) {
        // URL'/products/{id}'の'{id}'部分と主キー（idカラム）の値が一致するデータをproductsテーブルから取得し、変数$productに代入する
        // Productはデータベース内のproductsテーブルと紐付けされているProductモデル
        $product = Product::find($id);

        // 変数$productをproducts/show.blade.phpファイルに渡す
        return view('products.show', compact('product'));

    }
}
