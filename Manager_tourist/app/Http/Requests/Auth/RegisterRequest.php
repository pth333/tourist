<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'bail|required|min:3|max:50',
            'email' => 'email|max:255',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name' => [
                'min' => 'Yêu cầu nhập tối thiểu 3 ký tự',
                'max' => 'Chỉ được nhập tối đa 50 ký tự',
            ],
            'password' => 'Xác nhận trường mật khẩu không khớp',
            'min' => 'Yêu cầu nhập tối thiểu 6 ký tự'
        ];
    }
}
