<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:20',
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:50',
            'building' => 'nullable|string|max:100',
            'profile_image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '名前は必須です',
            'name.max' => '名前は20文字以内で入力してください',
            'postal_code.regex' => '郵便番号はXXX-XXXXの形式で入力してください',
            'address.max' => '住所は50文字以内で入力してください',
            'building.max' => '建物名は100文字以内で入力してください',
            'profile_image.mimes' => 'プロフィール画像はJPEGまたはPNG形式のファイルを選択してください',
            'profile_image.max' => 'プロフィール画像のサイズは2MB以下を選択してください',
        ];
    }
}
