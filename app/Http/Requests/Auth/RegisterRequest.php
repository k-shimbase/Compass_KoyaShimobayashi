<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆バリデーション指定
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function rules() {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u', //正規表現 \Aが文頭 \zが文末 /.../uはUTF-8指定で必須らしい [ァ-ヴー]+は "ァ-ヴ, ー"のグループ化でそれらの何れかの文字が1回以上という意味合い
            'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'mail_address' => 'required|email|unique:users,mail_address|max:100',
            'sex' => 'required|in:1,2,3',
            'old_year' => 'required', //存在する日付か否か/未来日か否かはRegisterUserControllerで判定
            'old_month' => 'required',
            'old_day' => 'required',
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed',
        ];
    }

    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    // ◆$errorsのエラーメッセージ
    //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
    public function messages(){
        return [
            'over_name.required' => '姓は必ず入力してください。',
            'over_name.string' => '姓は文字列で記入してください。',
            'over_name.max' => '姓は10文字以下で記入してください。',

            'under_name.required' => '名前は必ず入力してください。',
            'under_name.string' => '名前は文字列で記入してください。',
            'under_name.max' => '名前は10文字以下で記入してください。',

            'over_name_kana.required' => 'セイは必ず入力してください。',
            'over_name_kana.string' => 'セイは文字列で記入してください。',
            'over_name_kana.regex' => 'セイはカタカナで記入してください。',
            'over_name_kana.max' => 'セイは30文字以下で記入してください。',

            'under_name_kana.required' => 'メイは必ず入力してください。',
            'under_name_kana.string' => 'メイは文字列で記入してください。',
            'under_name_kana.regex' => 'メイはカタカナで記入してください。',
            'under_name_kana.max' => 'メイは30文字以下で記入してください。',

            'mail_address.required' => 'メールアドレスは必ず入力してください。',
            'mail_address.email' => 'メールアドレスはメール形式で入力してください。',
            'mail_address.unique' => 'このメールアドレスは既に使用されています。',
            'mail_address.max' => 'メールアドレスは100文字以下で記入してください。',

            'sex.required' => '性別は必ず選択してください。',

            'old_year.required' => '生年月日は必ず入力してください。',
            'old_month.required' => '生年月日は必ず入力してください。',
            'old_day.required' => '生年月日は必ず入力してください。',

            'role.required' => '役職は必ず選択してください。',

            'password.required' => 'パスワードは必ず選択してください。',
            'password.min' => 'パスワードは8文字以上30文字以下で記入してください。',
            'password.max' => 'パスワードは8文字以上30文字以下で記入してください。',
            'password.confirmed' => 'パスワードが確認用パスワードと一致しません。',
        ];
    }
}
