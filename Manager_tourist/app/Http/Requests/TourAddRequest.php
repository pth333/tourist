<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TourAddRequest extends FormRequest
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
            'name_tour' => 'bail|required|min:3|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'type_vehical' => 'required',
            'departure_day' => 'required|date',
            'return_day' => 'required|date|after:departure_day'
        ];
    }

    public function messages()
    {
        return [
            'name_tour' => [
                'required' => 'Tên tour không được để trống',
                'min' => 'Yêu cầu nhập tối thiểu 3 ký tự',
                'max' => 'Chỉ được nhập tối đa 255 ký tự',
            ],
            'description.required' => 'Mô tả không được để trống',
            'price' => [
                'required' => 'Giá tour không được để trống',
                'numeric' => 'Giá tour phải là một số',
                'min' => 'Giá sản phẩm pahir lớn hơn 0'
            ],
            'type_vehical.required' => 'Loại phương tiện không được để trống',
            'departure_day' => [
                'required' => 'Ngày khởi hành không được để trống',
                'date' => 'Ngày khởi hành phải là ngày hợp lệ'
            ],
            'return_day' => [
                'required' => 'Ngày trở về không được để trống',
                'date' => 'Ngày trở về phải là ngày hợp lệ',
                'after' => 'Ngày trở về phải sau ngày khởi hành'
            ]
        ];
    }
}
