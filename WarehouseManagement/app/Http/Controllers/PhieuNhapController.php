<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NhaCungCap;
use App\Models\NguyenLieu;
use App\Models\LoaiNguyenLieu;
use App\Http\Requests\ExcelRequest;
use App\Factories\RepositoryFactory;
use Shuchkin\SimpleXLSX;

class PhieuNhapController extends Controller
{
    protected $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index()
    {
        $nha_cung_cap = NhaCungCap::all();
        $Ma_Phieu_Nhap = $this->generateRandomNumber();
        $phieu_nhap = $this->factory->createPhieuNhapRepository()->getAllWithUser();
        return view('nhapkho.index', compact('phieu_nhap', 'Ma_Phieu_Nhap', 'nha_cung_cap'));
    }

    private function generateRandomNumber()
    {
        do {
            $randomNumber = mt_rand(1000000000, 9999999999);
        } while (\App\Models\PhieuNhap::where('Ma_Phieu_Nhap', $randomNumber)->exists());
        return $randomNumber;
    }

    public function create()
    {
        $nguyen_lieu = NguyenLieu::all();
        $nha_cung_cap = NhaCungCap::all();
        $loai_nguyen_lieu = LoaiNguyenLieu::all();
        $Ma_Phieu_Nhap = $this->generateRandomNumber();
        return view('nhapkho.create', compact('Ma_Phieu_Nhap', 'nguyen_lieu', 'nha_cung_cap', 'loai_nguyen_lieu'));
    }

    public function show($code)
    {
        $phieu_nhap = $this->factory->createPhieuNhapRepository()->find($code);
        $chi_tiet_phieu_nhap = $this->factory->createPhieuNhapRepository()->getChiTietPhieuNhap($code);
        return view('nhapkho.show', compact('phieu_nhap', 'chi_tiet_phieu_nhap'));
    }

    public function import(ExcelRequest $request)
    {
        $data = $request->all();
        $file = $request->file('excel_file');
        $path = $file->getRealPath();

        if ($xlsx = SimpleXLSX::parse($path)) {
            $excelData = $xlsx->rows();
        } else {
            Alert::error('Thất bại', 'Lỗi đọc file Excel!');
            return back();
        }

        $tongtien = 0;
        $chiTietData = [];
        foreach (array_slice($excelData, 1) as $row) {
            $soLuong = $row[1] ?? 0;
            $giaNhap = $row[2] ?? 0;
            $tongtien += $soLuong * $giaNhap;
            $chiTietData[] = [
                'Ma_Nguyen_Lieu' => $row[0] ?? null,
                'So_Luong' => $row[1] ?? null,
                'Gia_Nhap' => $row[2] ?? null,
                'Ngay_San_Xuat' => $row[3] ?? null,
                'Thoi_Gian_Bao_Quan' => $row[4] ?? null,
            ];
        }

        if ($tongtien == 0) {
            Alert::error('Thất bại', 'Dữ liệu số lượng hoặc giá nhập không hợp lệ!');
            return back();
        }

        try {
            $phieuNhap = $this->factory->createPhieuNhapRepository()->createWithChiTiet([
                'Ma_Phieu_Nhap' => $data['Ma_Phieu_Nhap'],
                'Ngay_Nhap' => $data['Ngay_Nhap'],
                'Tong_Tien' => $tongtien,
                'Ma_NCC' => $data['Ma_NCC'],
                'Mo_Ta' => $this->processDescription($request->Mo_Ta),
                'ID_user' => auth()->id(),
            ], $chiTietData);

            Alert::success('Thành công', 'Nhập nguyên liệu thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Nhập nguyên liệu thất bại: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($code)
    {
        $status = $this->factory->createPhieuNhapRepository()->delete($code);
        if ($status) {
            Alert::success('Thành công', 'Xóa thành công!');
            return redirect()->back();
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

    private function processDescription($Mo_Ta)
    {
        if ($this->isJson($Mo_Ta)) {
            $jsonData = json_decode($Mo_Ta, true);
            if (isset($jsonData['ops']) && is_array($jsonData['ops'])) {
                $content = '';
                foreach ($jsonData['ops'] as $op) {
                    $content .= $op['insert'] ?? '';
                }
                return trim(strip_tags($content)) ?: 'Không có mô tả cụ thể!';
            }
        }
        return $Mo_Ta && trim($Mo_Ta) ? strip_tags($Mo_Ta) : 'Không có mô tả cụ thể!';
    }

    private function isJson($string)
    {
        return is_string($string) && json_decode($string) && json_last_error() === JSON_ERROR_NONE;
    }
}
