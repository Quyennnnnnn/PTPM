<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class XuatKhoExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings() : array
    {
        return [
            'STT',
            'Mã hàng hóa',
            'Tên hàng hóa',
            'Đơn vị tính',
            'Số lượng',
            'Đơn giá',
            'Thành tiền',
            'Ngày sản xuất',
            'Thời gian bảo quản(tháng)',
            'Nhà cung cấp'
        ];
    }
}
