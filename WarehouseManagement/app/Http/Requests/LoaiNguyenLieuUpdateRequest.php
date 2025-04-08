<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LoaiNguyenLieu;

class LoaiNguyenLieuUpdateRequest extends FormRequest
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
        $id = $this->route('loai-nguyen-lieu'); // đảm bảo route sử dụng đúng tên tham số
        $ten_loai_rule = 'required|max:100';

        // Lấy loại nguyên liệu hiện tại từ database
        $loaiNguyenLieu = LoaiNguyenLieu::find($id);

        // Kiểm tra nếu loại nguyên liệu tồn tại và tên bị thay đổi mới áp dụng unique
        if ($loaiNguyenLieu && $this->Ten_Loai_Nguyen_Lieu !== $loaiNguyenLieu->Ten_Loai_Nguyen_Lieu) {
            $ten_loai_rule .= '|unique:loai_nguyen_lieu,Ten_Loai_Nguyen_Lieu,' . $id;
        }

        return [
            'Ten_Loai_Nguyen_Lieu' => $ten_loai_rule,
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
