<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    //  フォームリクエストを作成したら、あとはコントローラのアクションの引数にフォームリクエスト名 $requestのように型宣言を行えばOKです。
    
    // authorize メソッド: このリクエストを誰が実行できるかを制御します。true を返すことで、すべてのユーザーにリクエストを許可
    // return auth()->user()->isAdmin(); にすれば管理者のみtrueを返し、リクエストを許可する
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // このメソッドは、リクエストデータに適用するバリデーションルールを定義します。送信されたデータがこのルールに基づいてバリデーションされる、FormRequestクラスのメソッド
    // このrules()メソッドの中で、フォームのname属性をキー、バリデーションルールを値にした連想配列を返すことで、バリデーションを設定できます
    public function rules(): array
    {
        return [
            'product_name' => 'required|max:255',
            'price' => 'required|integer|min:1',
            'vendor_code' => 'exists:vendors,vendor_code'
        ];
    }
}
