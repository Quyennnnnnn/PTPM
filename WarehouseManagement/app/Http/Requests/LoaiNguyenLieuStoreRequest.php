<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoaiNguyenLieuStoreRequest extends FormRequest
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
            'Ten_Loai_Nguyen_Lieu' => 'required|max:100|unique:loai_nguyen_lieu,Ten_Loai_Nguyen_Lieu',
            'Mo_Ta' => 'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'Ten_Loai_Nguyen_Lieu.required' => 'Vui lòng nhập tên loại nguyên liệu',
            'Ten_Loai_Nguyen_Lieu.max' => 'Tên loại nguyên liệu không được vượt quá :max ký tự',
            'Ten_Loai_Nguyen_Lieu.unique' => 'Tên loại nguyên liệu đã tồn tại, vui lòng chọn tên khác',
            'Mo_Ta.string' => 'Mô tả phải là một chuỗi văn bản'
        ];
    }
}
