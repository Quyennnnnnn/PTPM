<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NguyenLieuStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'Ten_Nguyen_Lieu' => 'required|string|max:255',
            'Don_Vi_Tinh' => 'required|string|max:50',
            'Barcode' => 'nullable|string|max:100',
            'Ma_loai_nguyen_lieu' => 'required',
            'Mo_Ta' => 'nullable|string',
        ];
    }


    /**
     * Custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'Ten_Nguyen_Lieu.required' => 'Tên nguyên liệu không được bỏ trống.',
            'Ten_Nguyen_Lieu.max' => 'Tên nguyên liệu không được vượt quá :max ký tự.',

            'Mo_Ta.string' => 'Mô tả phải là chuỗi ký tự.',

            'Don_Vi_Tinh.required' => 'Đơn vị tính không được bỏ trống.',
            'Don_Vi_Tinh.max' => 'Đơn vị tính không được vượt quá :max ký tự.',

            'Barcode.max' => 'Mã vạch không được vượt quá :max ký tự.',
            'Barcode.regex' => 'Mã vạch chỉ chấp nhận ký tự chữ và số in hoa.',
            'Barcode.unique' => 'Mã vạch đã tồn tại.',

            'So_Luong_Ton.integer' => 'Số lượng tồn phải là số nguyên.',
            'So_Luong_Ton.min' => 'Số lượng tồn phải là số không âm.',

            'Ma_loai_nguyen_lieu.required' => 'Vui lòng chọn loại nguyên liệu.',
            'Ma_loai_nguyen_lieu.integer' => 'Loại nguyên liệu phải là số nguyên.',
            'Ma_loai_nguyen_lieu.exists' => 'Loại nguyên liệu không hợp lệ.',
        ];
    }
}
