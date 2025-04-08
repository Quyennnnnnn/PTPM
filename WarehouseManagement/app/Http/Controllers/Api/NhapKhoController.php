<?php

namespace App\Http\Controllers\Api;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuNhap;
use App\Models\NguyenLieu;
use Illuminate\Support\Facades\DB;

class NhapKhoController extends Controller
{
    public function index()
    {
        $phieuNhapList = PhieuNhap::all();
        return response()->json($phieuNhapList);
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


    
    public function store(Request $request)
    {
        $data = $request->all();

        $request->validate([
            'Ma_Phieu_Nhap' => 'required|max:20|unique:phieu_nhap,Ma_Phieu_Nhap',
            'Ngay_Nhap' => 'required|date',
            'Ma_NCC' => 'required|string',
            'So_Luong' => 'required|array',
            'Gia_Nhap' => 'required|array',
            'Ma_Nguyen_Lieu' => 'required|array',
        ]);

        $tongtien = 0;
        if (!empty($request->So_Luong) && !empty($request->Gia_Nhap)) {
            foreach ($request->So_Luong as $index => $soLuong) {
                $giaNhap = $request->Gia_Nhap[$index] ?? 0;
                $tongtien += $soLuong * $giaNhap;
            }
        } else {
            Alert::error('Thất bại', 'Dữ liệu số lượng hoặc giá nhập không hợp lệ!');
            return back();
        }

        DB::beginTransaction();

        try {
            $userId = auth()->user()->id;

            // Tạo phiếu nhập
            $phieuNhap = PhieuNhap::create([
                'Ma_Phieu_Nhap' => $request->Ma_Phieu_Nhap,
                'Ngay_Nhap' => $request->Ngay_Nhap,
                'Tong_Tien' => $tongtien,
                'Ma_NCC' => $request->Ma_NCC,
                'Mo_Ta' => $this->processDescription($request->Mo_Ta),
                'ID_user' => $userId,
            ]);

            // Tạo chi tiết phiếu nhập
            foreach ($data['Ma_Nguyen_Lieu'] as $index => $maNguyenLieu) {
                $chiTietData = [
                    'Ma_Nguyen_Lieu' => $maNguyenLieu ?? null,
                    'So_Luong' => $data['So_Luong'][$index] ?? null,
                    'Gia_Nhap' => $data['Gia_Nhap'][$index] ?? null,
                    'Ngay_San_Xuat' => $data['Ngay_San_Xuat'][$index] ?? null,
                    'Thoi_Gian_Bao_Quan' => $data['Thoi_Gian_Bao_Quan'][$index] ?? null,
                ];

                // Kiểm tra dữ liệu
                if ($chiTietData['Ma_Nguyen_Lieu'] && $chiTietData['So_Luong'] && $chiTietData['Gia_Nhap'] && $chiTietData['Ngay_San_Xuat'] && $chiTietData['Thoi_Gian_Bao_Quan']) {
                    $nguyenLieu = NguyenLieu::where('Ma_Nguyen_Lieu', $chiTietData['Ma_Nguyen_Lieu'])->first();
                    if (!$nguyenLieu) {
                        throw new \Exception("Nguyên liệu không tồn tại: {$chiTietData['Ma_Nguyen_Lieu']}");
                    }

                    // Tạo chi tiết phiếu nhập
                    ChiTietPhieuNhap::create([
                        'Ma_Phieu_Nhap' => $phieuNhap->Ma_Phieu_Nhap,
                        'Ma_Nguyen_Lieu' => $chiTietData['Ma_Nguyen_Lieu'],
                        'So_Luong_Nhap' => $chiTietData['So_Luong'],
                        'Gia_Nhap' => $chiTietData['Gia_Nhap'],
                        'Ngay_San_Xuat' => $chiTietData['Ngay_San_Xuat'],
                        'Thoi_Gian_Bao_Quan' => $chiTietData['Thoi_Gian_Bao_Quan'],
                    ]);

                    // Cập nhật số lượng tồn của nguyên liệu
                    $nguyenLieu->So_Luong_Ton += $chiTietData['So_Luong'];
                    $nguyenLieu->save();
                } else {
                    throw new \Exception("Dữ liệu chi tiết không hợp lệ tại dòng " . ($index + 1));
                }
            }

            DB::commit();
            Alert::success('Thành công', 'Nhập nguyên liệu thành công!');
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($phieuNhap)) {
                $phieuNhap->delete();
            }

            Alert::error('Thất bại', 'Lỗi nhập nguyên liệu: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
