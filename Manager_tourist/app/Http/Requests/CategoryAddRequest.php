<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryAddRequest extends FormRequest
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
            'name' => 'bail|required|unique:categories|max:255|string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được trống',
            'name.unique' => 'Danh mục không được trùng',
            'name.max' => 'Không nhập quá 255 ký tự',
            'name.string' => 'Danh mục phải là một chuỗi ký tự'
        ];
    }
}
