<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestinationAddRequest extends FormRequest
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
            'name_des' => 'bail|required|unique:destinations|max:255',
            'address' => 'required',
            'description' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name_des' => [
                'required' => 'Địa điểm không được để trống',
                'unique' => 'Địa điểm không được để trùng',
                'max' => 'Chỉ được nhập tối đa 255 ký tự'
            ],
            'address.required' => 'Địa chỉ không được để trống',
            'description.required' => 'Mô tả không được để trống'
        ];
    }
}
