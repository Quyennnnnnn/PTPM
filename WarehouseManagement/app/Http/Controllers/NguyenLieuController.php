<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\NguyenLieu;
use App\Models\LoaiNguyenLieu;
use App\Models\PhieuNhap;
use App\Models\ChiTietPhieuXuat;
use Illuminate\Http\Request;
use App\Http\Requests\NguyenLieuStoreRequest;
use App\Http\Requests\NguyenLieuUpdateRequest;
use App\Models\ChiTietPhieuNhap;
use Illuminate\Support\Facades\Log;
use Storage;
use Illuminate\Support\Str;


class NguyenLieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $nguyen_lieu = NguyenLieu::all(); // Lấy toàn bộ dữ liệu nguyên liệu
        return view('nguyenlieu.index', compact('nguyen_lieu'));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Ma_Nguyen_Lieu = NguyenLieu::generateMaNguyenLieu();
        $loai_nguyen_lieu = LoaiNguyenLieu::all();
        return view('nguyenlieu.create', compact('loai_nguyen_lieu','Ma_Nguyen_Lieu'));
    }
    
    
    public function store(NguyenLieuStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $Mo_Ta = json_decode($request->Mo_Ta)->ops[0]->insert ?? 'Không có mô tả cụ thể!';
            $nguyen_lieu = NguyenLieu::create([
                'Ma_Nguyen_Lieu' => $request->Ma_Nguyen_Lieu, 
                'Ten_Nguyen_Lieu' => $request->Ten_Nguyen_Lieu,
                'Mo_Ta' => $Mo_Ta,
                'Don_Vi_Tinh' => $request->Don_Vi_Tinh,
                'Barcode' => $request->Barcode ?: null,
                'Ma_loai_nguyen_lieu' => $request->Ma_loai_nguyen_lieu
            ]);
           
            if ($nguyen_lieu) {
                Alert::success('Thành công', 'Thêm mới nguyên liệu thành công!');
                return redirect()->route('nguyen-lieu.index');
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm nguyên liệu: ' . $e->getMessage());
            Alert::error('Thất bại', 'Có lỗi xảy ra: ' . $e->getMessage())->autoClose(5000);
            return back()->withInput();
        }
       
    }



    /**
     * Display the specified resource.
     */
    public function show($code)
    {
        $chi_tiet = ChiTietPhieuNhap::where('Ma_Nguyen_Lieu', $code)->paginate(10); 
    
        $nguyen_lieu = NguyenLieu::findOrFail($code);
        if ($chi_tiet->isEmpty()) {
            Alert::warning('Thông báo', 'Không có chi tiết phiếu nhập nào liên quan đến nguyên liệu này!')->autoClose(5000);
        }
        return view('nguyenlieu.show', compact('nguyen_lieu', 'chi_tiet'));
    }
    

    public function edit($code)
    {
        // Lấy tất cả loại nguyên liệu
        $loai_nguyen_lieu = LoaiNguyenLieu::all();

        // Tìm nguyên liệu theo mã
        $nguyen_lieu = NguyenLieu::where('Ma_Nguyen_Lieu', $code)->first();

        if ($nguyen_lieu) {
            return view('nguyenlieu.edit', compact('nguyen_lieu', 'loai_nguyen_lieu'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy nguyên liệu, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    private function processDescription($Mo_Ta)
     {
         // Kiểm tra nếu đầu vào là JSON
         if ($this->isJson($Mo_Ta)) {
             $jsonData = json_decode($Mo_Ta, true);
     
             // Kiểm tra nếu tồn tại trường 'ops' và nó là một mảng
             if (isset($jsonData['ops']) && is_array($jsonData['ops'])) {
                 $content = '';
     
                 // Duyệt qua từng phần tử trong 'ops' để lấy dữ liệu
                 foreach ($jsonData['ops'] as $op) {
                     // Thêm nội dung từ trường 'insert', nếu tồn tại
                     $content .= $op['insert'] ?? '';
                 }
     
                 // Loại bỏ các thẻ HTML và trả về kết quả
                 return trim(strip_tags($content)) ?: 'Không có mô tả cụ thể!';
             }
         }
     
         // Nếu không phải JSON hoặc không hợp lệ, xử lý chuỗi gốc
         return $Mo_Ta && trim($Mo_Ta) ? strip_tags($Mo_Ta) : 'Không có mô tả cụ thể!';
     }
     
    private function isJson($string)
    {
        return is_string($string) && json_decode($string) && json_last_error() === JSON_ERROR_NONE;
    }

    public function update(NguyenLieuUpdateRequest $request, $code)
    {
        $data = $request->validated();
        $nguyen_lieu = NguyenLieu::where('Ma_Nguyen_Lieu', $code)->firstOrFail();
        $Mo_Ta = $this->processDescription($data['Mo_Ta'] ?? null);
    
        // Cập nhật các trường của nguyên liệu
        $status = $nguyen_lieu->update([
            'Ten_Nguyen_Lieu' => $data['Ten_Nguyen_Lieu'],
            'Mo_Ta' => $Mo_Ta,
            'Don_Vi_Tinh' => $data['Don_Vi_Tinh'],
            'Barcode' => empty($data['Barcode']) ? null : $data['Barcode'],
            'So_Luong_Ton' => $data['So_Luong_Ton'] ?? $nguyen_lieu->So_Luong_Ton,
            'Ma_Loai_Nguyen_Lieu' => $data['Ma_Loai_Nguyen_Lieu']
        ]);
        
    
        if ($status) {
    
            Alert::success('Thành công', 'Cập nhật thông tin nguyên liệu thành công!');
            return redirect()->route('nguyen-lieu.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình cập nhật. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $status = NguyenLieu::destroy($id);
        if ($status) {
            Alert::success('Thành công', 'Xóa thông tin nguyên liệu thành công!');
            return redirect()->route('nguyen-lieu.index');
        } else{
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }
}
