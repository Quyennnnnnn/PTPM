<?php

namespace App\Exports;

use App\Models\NguyenLieu;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ThongKeExport implements FromCollection, WithHeadings, WithColumnFormatting
{
    protected $nguyenLieuData;

    public function __construct($nguyen_lieu)
    {
        $this->nguyenLieuData = $nguyen_lieu;
    }

    /**
     * Lấy dữ liệu cần xuất
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->nguyenLieuData;
    }

    /**
     * Đặt tiêu đề cột trong file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'STT',
            'Mã nguyên liệu',
            'Tên nguyên liệu',
            'Số lượng tồn',
            'Giá nhập',
            'Tổng giá trị nhập',
            'Tổng giá trị xuất',
        ];
    }

    /**
     * Định dạng các cột trong file Excel
     *
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,  // Định dạng giá trị nhập
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,  // Định dạng tổng giá trị nhập
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,  // Định dạng tổng giá trị xuất
        ];
    }
}
