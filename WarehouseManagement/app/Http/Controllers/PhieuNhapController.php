<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuNhap;
use App\Models\NguyenLieu;
use App\Models\NhaCungCap;
use App\Models\LoaiNguyenLieu;
use App\Http\Requests\ExcelRequest;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\DB;

class PhieuNhapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nha_cung_cap = NhaCungCap::all();
        $Ma_Phieu_Nhap = $this->generateRandomNumber();
        $phieu_nhap = PhieuNhap::with('User')
        ->orderBy('Ngay_Nhap', 'DESC')
        ->get();

        // Trả dữ liệu về view
       return view('nhapkho.index', compact('phieu_nhap', 'Ma_Phieu_Nhap', 'nha_cung_cap'));
    }

    private function generateRandomNumber()
    {

        do {
            $randomNumber = mt_rand(1000000000, 9999999999); 
        } while (PhieuNhap::where('Ma_Phieu_Nhap', $randomNumber)->exists()); 

        return $randomNumber;
    }

    /**
     * Show the form for creating a new resource.
     */
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
        $phieu_nhap = PhieuNhap::with('User')->where('Ma_Phieu_Nhap', $code)->firstOrFail();

        $chi_tiet_phieu_nhap = ChiTietPhieuNhap::with('getNguyenLieu')->where('Ma_Phieu_Nhap', $code)->paginate(10);

        return view('nhapkho.show', compact('phieu_nhap','chi_tiet_phieu_nhap'));
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
        foreach (array_slice($excelData, 1) as $row) {
            $soLuong = $row[1] ?? 0;
            $giaNhap = $row[2] ?? 0;
            $tongtien += $soLuong * $giaNhap;
        }

        if ($tongtien == 0) {
            Alert::error('Thất bại', 'Dữ liệu số lượng hoặc giá nhập không hợp lệ!');
            return back();
        }

        try {
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $phieuNhap = PhieuNhap::create([
                'Ma_Phieu_Nhap' => $data['Ma_Phieu_Nhap'],
                'Ngay_Nhap' => $data['Ngay_Nhap'],
                'Tong_Tien' => $tongtien,
                'Ma_NCC' => $data['Ma_NCC'],
                'Mo_Ta' => $this->processDescription($request->Mo_Ta),
                'ID_user' => $userId,
            ]);
            foreach (array_slice($excelData, 1) as $row) {
                $chiTietData = [
                    'Ma_Nguyen_Lieu' => $row[0] ?? null,
                    'So_Luong' => $row[1] ?? null,
                    'Gia_Nhap' => $row[2] ?? null,
                    'Ngay_San_Xuat' => $row[3] ?? null,
                    'Thoi_Gian_Bao_Quan' => $row[4] ?? null,
                ];

                if ($chiTietData['Ma_Nguyen_Lieu'] && $chiTietData['So_Luong'] && $chiTietData['Gia_Nhap'] && $chiTietData['Ngay_San_Xuat'] && $chiTietData['Thoi_Gian_Bao_Quan']) {
                    $nguyenLieu = NguyenLieu::where('Ma_Nguyen_Lieu', $chiTietData['Ma_Nguyen_Lieu'])->first();
                    if (!$nguyenLieu) {
                        throw new \Exception('Nguyên liệu không tồn tại: ' . $chiTietData['Ma_Nguyen_Lieu']);
                    }

                    ChiTietPhieuNhap::create([
                        'Ma_Phieu_Nhap' => $phieuNhap->Ma_Phieu_Nhap,
                        'Ma_Nguyen_Lieu' => $chiTietData['Ma_Nguyen_Lieu'],
                        'So_Luong_Nhap' => $chiTietData['So_Luong'],
                        'Gia_Nhap' => $chiTietData['Gia_Nhap'],
                        'Ngay_San_Xuat' => $chiTietData['Ngay_San_Xuat'],
                        'Thoi_Gian_Bao_Quan' => $chiTietData['Thoi_Gian_Bao_Quan'],
                    ]);
                    $nguyenLieu->So_Luong_Ton += $chiTietData['So_Luong'];
                    $nguyenLieu->save();
                } else {
                    throw new \Exception('Dữ liệu không hợp lệ trong file Excel tại dòng ' );
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
            Alert::error('Thất bại', 'Nhập nguyên liệu thất bại: ' . $e->getMessage());
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


    public function destroy($code)
    {
        $status = ChiTietPhieuNhap::where('Ma_Phieu_Nhap', $code)->delete() && PhieuNhap::where('Ma_Phieu_Nhap', $code)->delete();

        if ($status) {
            Alert::success('Thành công', 'Xóa thành công!');
            return redirect()->back();
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }
    

}
