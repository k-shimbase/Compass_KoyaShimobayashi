<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ];
    }

    public function messages(){
        return [
            'main_category_id.required' => 'メインカテゴリーは必ず選択してください。',
            'main_category_id.exists' => '存在しないメインカテゴリーです。',

            'sub_category_name.required' => 'サブカテゴリー名は必ず記入してください。',
            'sub_category_name.string' => 'サブカテゴリー名は文字列で記入してください。',
            'sub_category_name.max' => 'サブカテゴリー名は100文字以下で記入してください。',
            'sub_category_name.unique' => 'このサブカテゴリー名は既に使用されています。',
        ];
    }
}
