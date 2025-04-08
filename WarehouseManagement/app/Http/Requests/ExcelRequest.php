<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelRequest extends FormRequest
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
            'excel_file' => 'required|mimes:xls,xlsx|max:10240'
        ];
    }

    public function message()
    {
        return [
            'excel_file.required' => 'Vui lòng chọn một tệp tin để tải lên',
            'excel_file.mimes' => 'Tệp tin phải có định dạng xls hoặc xlsx',
            'excel_file.max' => 'Tệp tin tải lên không được quá 10MB'
        ];
    }
}
