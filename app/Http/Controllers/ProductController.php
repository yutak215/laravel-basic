<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Vendor;
use App\Http\Requests\ProductStoreRequest;
use App\Events\ProductAddedEvent;


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

    // 説明:
    // 役割: このcreateメソッドは、商品を作成するためのフォームを表示します。フォーム内には、vendors テーブルから取得した vendor_code のリストを使って、仕入先を選択できるドロップダウンメニューなどが含まれる。
    // Vendor::pluck('vendor_code'): Vendor モデル（データベース）を使って、vendors テーブルの vendor_code カラムのすべての値を取得します。pluck メソッドは、特定のカラムの値をコレクションとして取得するために使います。
    //　出力:　products.create ビューが表示され、そこには新しい商品を作成するためのフォームがあり、フォーム内で vendor_codes を使用することができます（例えば、仕入先コードの選択）。
    public function create() {
        $vendor_codes = Vendor::pluck('vendor_code');

        return view('products.create', compact('vendor_codes'));
    }

//説明:
// 役割: このstoreメソッドは、フォームから送信された商品データをバリデーションした後、データベースに保存します。

    // ProductStoreRequest $request: ProductStoreRequest クラスは、バリデーションするためのフォームリクエストクラスを継承したコントローラー（作成済み）、
    // リクエストがこのメソッドに渡る前に自動的にバリデーションが行われます。バリデーションに成功すると、次のステップへ進みます。
    public function store(ProductStoreRequest $request) {
        // フォームの入力内容をもとに、テーブルにデータを追加する
        $product = new Product();
        // $request->input('field'): フォームで送信されたデータを取得します。
        // input() メソッドでリクエストデータの特定のフィールド（product_name、price、vendor_code）の値を取り出しています。
        $product->product_name = $request->input('product_name');
        $product->price = $request->input('price');
        $product->vendor_code = $request->input('vendor_code');

        // アップロードされたファイル（name="image"）が存在すれば処理を実行する
        if ($request->hasFile('image')) {
            // アップロードされたファイル（name="image"）をstorage/app/public/productsフォルダに保存し、戻り値（ファイルパス）を変数$image_pathに代入する
            $image_path = $request->file('image')->store('public/products');
            // ファイルパスからファイル名のみを取得し、Productインスタンスのimage_nameプロパティに代入する
            $product->image_name = basename($image_path);
        }

        // $product->save();: ここで新しい商品がデータベースに保存されます。Eloquent ORMを使って、products テーブルに新しいレコードが追加されます。
        $product->save();

        // ProductAddedEventを発生させる
        event(new ProductAddedEvent($product));

        // リダイレクト: return redirect("/products/{$product->id}");: 商品が保存された後、/products/{id} というURLにリダイレクトします。
        // このURLは、保存した商品の詳細ページであり、ユーザーはその新しく作成された商品を見ることができます。
        return redirect("/products/{$product->id}");
    }
}
