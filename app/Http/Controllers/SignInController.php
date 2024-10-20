<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SignInController extends Controller
{
    public function create()
     {
         return view('sign-in.create');
     }
 
     public function store(Request $request)
     {
         $email = $request->input('email');
         $password = $request->input('password');
 
         // メールアドレスとパスワードに一致するデータがusersテーブルに存在すればtrue、存在しなければfalse
         $user_exists = User::whereRaw("email = '${email}'")->whereRaw("password = '${password}'")->exists();
 
         // クエリの結果に応じて文字列をHTTPレスポンスとして生成して返す
         if ($user_exists) {
             return "ログインに成功しました。";
         } else {
             return "ログインに失敗しました。";
         }
     }
}
