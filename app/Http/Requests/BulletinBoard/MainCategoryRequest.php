<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ];
    }

    public function messages(){
        return [
            'main_category_name.required' => 'メインカテゴリー名は必ず記入してください。',
            'main_category_name.string' => 'メインカテゴリー名は文字列で記入してください。',
            'main_category_name.max' => 'メインカテゴリー名は100文字以下で記入してください。',
            'main_category_name.unique' => 'このメインカテゴリー名は既に使用されています。',
        ];
    }
}
