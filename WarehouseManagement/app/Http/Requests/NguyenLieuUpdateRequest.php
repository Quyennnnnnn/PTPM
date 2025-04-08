<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NguyenLieuUpdateRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'Ten_Nguyen_Lieu' => 'required|max:100',
            'Mo_Ta' => 'nullable|string',
            'Don_Vi_Tinh' => 'required|max:50',
            'Barcode' => ['nullable', 'string', 'max:100', 'regex:/^[A-Z0-9]+$/'],
            'So_Luong_Ton' => 'nullable|integer|min:0',
            // 'Image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'Ma_Loai_Nguyen_Lieu' => 'required|integer',
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
            'So_Luong_Ton.integer' => 'Số lượng tồn phải là số nguyên.',
            'So_Luong_Ton.min' => 'Số lượng tồn phải là số không âm.',

            'Ma_Loai_Nguyen_Lieu.required' => 'Vui lòng chọn loại nguyên liệu.',
            'Ma_Loai_Nguyen_Lieu.integer' => 'Loại nguyên liệu phải là số nguyên.',
            'Ma_Loai_Nguyen_Lieu.exists' => 'Loại nguyên liệu không hợp lệ.',
        ];
    }
}
