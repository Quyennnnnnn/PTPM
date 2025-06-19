<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Http\Requests\LoaiNguyenLieuStoreRequest;
use App\Http\Requests\LoaiNguyenLieuUpdateRequest;
use Illuminate\Support\Facades\Log;
use App\Factories\RepositoryFactory;

class LoaiNguyenLieuController extends Controller
{
    protected $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index()
    {
        $loai_nguyen_lieu = $this->factory->createLoaiNguyenLieuRepository()->getAllSorted();
        return view('loainguyenlieu.index', compact('loai_nguyen_lieu'));
    }

    public function create()
    {
        $Ma_Loai_Nguyen_Lieu = \App\Models\LoaiNguyenLieu::generateMaLoaiNguyenLieu();
        return view('loainguyenlieu.create', compact('Ma_Loai_Nguyen_Lieu'));
    }

    public function store(LoaiNguyenLieuStoreRequest $request)
    {
        try {
            $data = $request->all();
            $Mo_Ta = $this->processDescription($request->Mo_Ta);
            $status = $this->factory->createLoaiNguyenLieuRepository()->create([
                'Ma_Loai_Nguyen_Lieu' => $request->Ma_Loai_Nguyen_Lieu,
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

    public function show($id)
    {
        $loai_nguyen_lieu = $this->factory->createLoaiNguyenLieuRepository()->find($id);
        $nguyen_lieu = $this->factory->createLoaiNguyenLieuRepository()->getNguyenLieuByLoai($id);

        if ($loai_nguyen_lieu) {
            return view('loainguyenlieu.show', compact('loai_nguyen_lieu', 'nguyen_lieu'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy loại nguyên liệu này.');
            return back();
        }
    }

    public function edit($id)
    {
        $loai_nguyen_lieu = $this->factory->createLoaiNguyenLieuRepository()->find($id);
        if (!$loai_nguyen_lieu) {
            Alert::error('Thất bại', 'Không tìm thấy loại nguyên liệu.');
            return back();
        }
        return view('loainguyenlieu.edit', compact('loai_nguyen_lieu'));
    }

    public function update(LoaiNguyenLieuUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $Mo_Ta = $this->processDescription($request->Mo_Ta);

        try {
            $status = $this->factory->createLoaiNguyenLieuRepository()->update($id, [
                'Ten_Loai_Nguyen_Lieu' => $data['Ten_Loai_Nguyen_Lieu'],
                'Mo_Ta' => $Mo_Ta
            ]);

            if ($status) {
                Alert::success('Thành công', 'Sửa thông tin loại nguyên liệu thành công!');
                return redirect()->route('loai-nguyen-lieu.index');
            } else {
                Alert::error('Thất bại', 'Không thể cập nhật loại nguyên liệu!');
                return back();
            }
        } catch (\Exception $e) {
            Alert::error('Thất bại', 'Có lỗi trong quá trình chỉnh sửa loại nguyên liệu: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($id)
    {
        try {
            $status = $this->factory->createLoaiNguyenLieuRepository()->delete($id);
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
