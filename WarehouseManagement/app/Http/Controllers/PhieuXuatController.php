<?php

namespace App\Http\Controllers;
use App\Models\PhieuXuat;
use App\Models\NguyenLieu;
use App\Models\ChiTietPhieuXuat;
use App\Http\Requests\ExcelRequest;
use App\Models\LoaiNguyenLieu;
use App\Models\CoSo;
use RealRashid\SweetAlert\Facades\Alert;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\DB;

class PhieuXuatController extends Controller
{
    public function index()
    {
        $Ma_Phieu_Xuat =  $this->generateRandomNumber();
        $phieu_xuat = PhieuXuat::with('getUser')->orderBy('Ma_Phieu_Xuat', 'DESC')->paginate(10);
        $co_so=CoSo::all();
        return view('xuatkho.index', compact('phieu_xuat', 'Ma_Phieu_Xuat','co_so'));
    }

    private function generateRandomNumber()
    {

        do {
            $randomNumber = mt_rand(1000000000, 9999999999); 
        } while (PhieuXuat::where('Ma_Phieu_Xuat', $randomNumber)->exists()); 

        return $randomNumber;
    }
    public function create()
    {
        $Ma_Phieu_Xuat =  $this->generateRandomNumber();
        $loai_nguyen_lieu = LoaiNguyenLieu::all();
        $nguyen_lieu = NguyenLieu::all();
        $co_so=CoSo::all();

        return view('xuatkho.create', compact('Ma_Phieu_Xuat', 'loai_nguyen_lieu','nguyen_lieu','co_so'));
    }


    public function show($code)
    {
        $phieu_xuat = PhieuXuat::where('Ma_Phieu_Xuat', $code)->firstOrFail();

        $chi_tiet_phieu_xuat = ChiTietPhieuXuat::where('Ma_Phieu_Xuat', $phieu_xuat->Ma_Phieu_Xuat)->paginate(10);

        return view('xuatkho.show', compact('phieu_xuat', 'chi_tiet_phieu_xuat'));
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
            $giaXuat = $row[2] ?? 0;
            $tongtien += $soLuong * $giaXuat;
        }

        if ($tongtien == 0) {
            Alert::error('Thất bại', 'Dữ liệu số lượng hoặc giá nhập không hợp lệ!');
            return back();
        }

        try {
            DB::beginTransaction();
            $userId = auth()->user()->id;
            $phieuNhap = PhieuXuat::create([
                'Ma_Phieu_Xuat' => $request->Ma_Phieu_Xuat,
                'Ngay_Xuat' => $data['Ngay_Xuat'],
                'Mo_Ta' => $this->processDescription($request->Mo_Ta),
                'Ma_Co_So' => $data['Ma_Co_So'],
                'Tong_Tien' => $tongtien, 
                'ID_user' => auth()->id(),
            ]);
            foreach (array_slice($excelData, 1) as $row) {
                $chiTietData = [
                    'Ma_Nguyen_Lieu' => $row[0] ?? null,
                    'So_Luong_Xuat' => $row[1] ?? null,
                    'Gia_Xuat' => $row[2] ?? null,

                ];

                if ($chiTietData['Ma_Nguyen_Lieu'] && $chiTietData['So_Luong_Xuat'] && $chiTietData['Gia_Xuat']) {
                    $nguyenLieu = NguyenLieu::where('Ma_Nguyen_Lieu', $chiTietData['Ma_Nguyen_Lieu'])->first();
                    if (!$nguyenLieu) {
                        throw new \Exception('Nguyên liệu không tồn tại: ' . $chiTietData['Ma_Nguyen_Lieu']);
                    }

                    ChiTietPhieuXuat::create([
                        'Ma_Phieu_Xuat' => $phieuNhap->Ma_Phieu_Xuat,
                        'Ma_Nguyen_Lieu' => $chiTietData['Ma_Nguyen_Lieu'],
                        'So_Luong_Xuat' => $chiTietData['So_Luong_Xuat'],
                        'Gia_Xuat' => $chiTietData['Gia_Xuat'],
                    ]);
                    $nguyenLieu->So_Luong_Ton -= $chiTietData['So_Luong_Xuat'];
                    $nguyenLieu->save();
                } else {
                    throw new \Exception('Dữ liệu không hợp lệ trong file Excel tại dòng ' );
                }
            }

            DB::commit();
            Alert::success('Thành công', 'Xuất nguyên liệu thành công!');
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
        $status = ChiTietPhieuXuat::where('Ma_Phieu_Xuat', $code)->delete() && PhieuXuat::where('Ma_Phieu_Xuat', $code)->delete();

        if ($status) {
            Alert::success('Thành công', 'Xóa thành công!');
            return redirect()->back();
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

}
