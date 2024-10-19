<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;

class VendorController extends Controller
{
    public function show($id) {
        // URL'/vendors/{id}'の'{id}'部分と主キー（idカラム）の値が一致するデータをvendorsテーブルから取得し、変数$vendorに代入する
        $vendor = Vendor::find($id);

        // インスタンスに紐づくproductsテーブルのすべてのデータをインスタンスのコレクションとして取得する
        $products = $vendor->products;

        // 変数$vendorと変数$productsをvendors/show.blade.phpファイルに渡す
        return view('vendors.show', compact('vendor', 'products'));
    }

    public function create() {
        return view('vendors.create');
    }

    public function store(Request $request) {
        // $request->validate(): 入力されたデータが正しいかどうかをチェック。
        // new Vendor(): 新しいデータベースレコードを作成するためのモデルのインスタンスを作成。
        // $request->input(): ユーザーが入力したデータを取得。
        // $vendor->save(): データベースにそのデータを保存。
        // redirect(): 保存後、保存したデータの詳細ページにユーザーをリダイレクト。

        // 1バリデーション
        // バリデーションを設定する integer	整数のみ許可,unique:テーブル名,カラム名 指定したテーブルのカラムに重複する値が存在しなければ許可
        $request->validate([
            'vendor_code' => 'required|integer|min:0|unique:vendors,vendor_code',
            'vendor_name' => 'required|max:255'
        ]) ;
        
        // ②データー保存　フォームの入力内容をもとに、テーブルにデータを追加する
        // 新しい Vendor モデルのインスタンスを作成し、フォームのデータを取得してデータベースに保存
        $vendor = new Vendor();
        $vendor->vendor_code = $request->input('vendor_code');
        $vendor->vendor_name = $request->input('vendor_name');
        $vendor->save();

        // リダイレクトさせる
        return redirect("/vendors/{$vendor->id}");

    }
}
