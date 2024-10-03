<?php

namespace App\Http\Controllers;

// use宣言とは、「このファイルではこのクラスを使います」と宣言することです。
// つまり、HelloController.phpファイルの5行目に記述されているuse Illuminate\Http\Request;は、「このファイルではIlluminate\Httpフォルダの中にあるRequestクラスを使うよ」ということを宣言しています。
// このようにあらかじめ宣言しておくことで、そのファイル内ではRequestと記述するだけでRequestクラスを呼び出せるようになります。
// なお、RequestクラスはLaravelがあらかじめ用意してくれているクラスで、フォームから送信された内容などを取得してくれます。よって、実際にRequestクラスを使うのはstoreアクション（作成機能）やupdateアクション（更新機能）です。

use Exceptionn;
use Illuminate\Http\Request;


//　流れ
// １、web.php(ルーティング)で仕分け。/helloがついたら →HelloController内のindex メソッドを起動
// ２、index メソッド（名前はindexじゃなくてもよい）で　名前の変数を作成、それをヘルパー関数viewでindex.blade.php（blade.phpを省略)を表示させる、そして第二引数で変数を渡すために使うcompact関数で$nameを渡す
// ３、inndex.blade.phpで＄nameを表示
class HelloController extends Controller
{
    public function index() {
        $name = '侍 太郎';
        $languages = ['HTML', 'CSS', 'JavaScript', 'PHP'];

        // throw new Exception('例外が発生しました！');
 
        //  このように、view()ヘルパ関数でビューを指定するときはresources/viewsを省略し、フォルダ名.ファイル名（.blade.phpは不要）と記述します。
        // なお、今回表示するindex.blade.phpファイルはresources/viewsフォルダ直下に作成したので、フォルダ名は不要です。
        // 変数をビューに渡すには、view()ヘルパ関数の第2引数にPHPのcompact()関数を指定する方法が一般的です。compact()関数の引数にはビューに渡す変数名を文字列で指定しますが、先頭の$（ドル記号）は不要なので注意しましょう。
        // compact関数＝引数に渡された変数とその値から配列を作成し、戻り値として返す関数
        // compact関数で引数を渡す際、$は不要
         return view('index', compact('name', 'languages')); 
    }
}
