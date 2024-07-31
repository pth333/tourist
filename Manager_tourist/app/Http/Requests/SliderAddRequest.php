<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SliderAddRequest extends FormRequest
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
            'name' => 'bail|required|unique:sliders|max:255',
            'description' => 'required'
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên slider không được trống',
            'name.unique' => 'Slider không được trùng',
            'name.max' => 'Không nhập quá 255 ký tự',
            'description.required' => 'Mô tả không được để trống'
        ];
    }
}
