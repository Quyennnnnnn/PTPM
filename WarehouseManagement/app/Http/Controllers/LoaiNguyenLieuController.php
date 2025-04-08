<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\LoaiNguyenLieu; 
use App\Models\NguyenLieu;
use Illuminate\Http\Request;
use App\Http\Requests\LoaiNguyenLieuStoreRequest;
use App\Http\Requests\LoaiNguyenLieuUpdateRequest;
use Illuminate\Support\Facades\Log;

class LoaiNguyenLieuController extends Controller
{
    /**
     * Hiển thị danh sách loại nguyên liệu.
     */
    public function index()

    {
        $loai_nguyen_lieu = LoaiNguyenLieu::orderBy('Ma_Loai_Nguyen_Lieu')->get(); 
        return view('loainguyenlieu.index', compact('loai_nguyen_lieu'));
    }

    /**
     * Hiển thị form tạo loại nguyên liệu mới.
     */
    public function create()
    {
        $Ma_Loai_Nguyen_Lieu = LoaiNguyenLieu::generateMaLoaiNguyenLieu();
        // Lấy tất cả các loại nguyên liệu và sắp xếp theo id
        
        return view('loainguyenlieu.create', compact('Ma_Loai_Nguyen_Lieu')); 
    }

    /**
     * Lưu loại nguyên liệu mới vào cơ sở dữ liệu.
     */


    /**
     * Hiển thị thông tin chi tiết của một loại nguyên liệu.
     */
    public function show($id)
    {
        $loai_nguyen_lieu = LoaiNguyenLieu::find($id);
        $nguyen_lieu = NguyenLieu::where('Ma_loai_nguyen_lieu', $id)->get();

        if ($loai_nguyen_lieu) {
            return view('loainguyenlieu.show', compact('loai_nguyen_lieu', 'nguyen_lieu'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy loại nguyên liệu này.');
            return back();
        }
    }

    /**
     * Hiển thị form chỉnh sửa thông tin loại nguyên liệu.
     */
    public function edit($id)
    {
        $loai_nguyen_lieu = LoaiNguyenLieu::findOrFail($id);

        return view('loainguyenlieu.edit', compact('loai_nguyen_lieu'));
    }

    /**
     * Cập nhật thông tin của loại nguyên liệu.
     */
    public function update(LoaiNguyenLieuUpdateRequest $request, $id)
    {
        $data = $request->validated(); 

        $Mo_Ta = $this->processDescription($request->Mo_Ta);

        $loai_nguyen_lieu = LoaiNguyenLieu::findOrFail($id);
        

        try {
            $status = $loai_nguyen_lieu->update([
                'Ten_Loai_Nguyen_Lieu' => $data['Ten_Loai_Nguyen_Lieu'],
                'Mo_Ta' => $Mo_Ta
            ]);

            Alert::success('Thành công', 'Sửa thông tin loại nguyên liệu thành công!');
            return redirect()->route('loai-nguyen-lieu.index');
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Có lỗi trong quá trình chỉnh sửa loại nguyên liệu: ' . $e->getMessage());
            return back();
        }
    }
    public function store(LoaiNguyenLieuStoreRequest $request)
    {
        try { 
            
            $data = $request->all();
           
            $Mo_Ta = $this->processDescription($request->Mo_Ta);
            $status = LoaiNguyenLieu::create([
                'Ma_Loai_Nguyen_Lieu'=>$request->Ma_Loai_Nguyen_Lieu,
                'Ten_Loai_Nguyen_Lieu' => $data['Ten_Loai_Nguyen_Lieu'],
                'Mo_Ta' => $Mo_Ta
            ]);
    
            if ($status) {
                Alert::success('Thành công', 'Thêm mới loại nguyên liệu thành công!');
                return redirect()->route('loai-nguyen-lieu.index');
            } else {
                Alert::error('Thất bại', 'Không thể lưu loại nguyên liệu!');
                return back();
            }
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm loại nguyên liệu: ' . $e->getMessage());
            Alert::error('Thất bại', 'Đã có lỗi trong quá trình thêm loại nguyên liệu!')->autoClose(5000);
            return back();
        }
    }
    

    /**
     * Xóa loại nguyên liệu khỏi cơ sở dữ liệu.
     */
    public function destroy($id)
    {

        try {
            $status = LoaiNguyenLieu::destroy('Ma_Loai_Nguyen_Lieu',$id);

            if ($status) {
                Alert::success('Thành công', 'Xóa loại nguyên liệu thành công!');
                return redirect()->route('loai-nguyen-lieu.index');
            } else {
                Alert::error('Thất bại', 'Không thể xóa loại nguyên liệu này.');
                return back();
            }
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa loại nguyên liệu: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Kiểm tra và xử lý mô tả (nếu có JSON).
     */
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
