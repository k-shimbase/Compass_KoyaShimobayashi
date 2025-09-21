<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest {
    public function authorize() {
        return true;
    }

    public function rules()
    {
        return [
            'comment' => 'required|string|max:250',
        ];
    }

    public function messages(){
        return [
            'comment.required' => 'コメント内容は必ず記入してください。',
            'comment.string' => 'コメント内容は文字列で記入してください。',
            'comment.max' => 'コメント内容は250文字以下で記入してください。',
        ];
    }
}
