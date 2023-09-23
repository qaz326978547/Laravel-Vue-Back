<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; //這邊改成true，因為我們不需要驗證使用者是否有權限使用這個請求
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|required',
            'email' => 'string|required|email|unique:users',
            'password' => 'string|required|min:6|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '請輸入名稱',
            'email.required' => '請輸入email',
            'email.email' => '請輸入正確的email格式',
            'email.unique' => 'email已經被使用',
            'password.required' => '請輸入密碼',
            'password.min' => '密碼最少6個字',
            'password.confirmed' => '密碼與確認密碼不相符',
        ];
    }
}
