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
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }
}
