<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\LoaiNguyenLieu;
use Illuminate\Http\Request;
use App\Http\Requests\NguyenLieuStoreRequest;
use App\Http\Requests\NguyenLieuUpdateRequest;
use Illuminate\Support\Facades\Log;
use App\Factories\RepositoryFactory;

class NguyenLieuController extends Controller
{
    protected $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index()
    {
        $nguyen_lieu = $this->factory->createNguyenLieuRepository()->getAll();
        return view('nguyenlieu.index', compact('nguyen_lieu'));
    }

    public function create()
    {
        $Ma_Nguyen_Lieu = \App\Models\NguyenLieu::generateMaNguyenLieu();
        $loai_nguyen_lieu = LoaiNguyenLieu::all();
        return view('nguyenlieu.create', compact('loai_nguyen_lieu', 'Ma_Nguyen_Lieu'));
    }

    public function store(NguyenLieuStoreRequest $request)
    {
        try {
            $data = $request->validated();
            $Mo_Ta = $this->processDescription($request->Mo_Ta);
            $nguyen_lieu = $this->factory->createNguyenLieuRepository()->create([
                'Ma_Nguyen_Lieu' => $request->Ma_Nguyen_Lieu,
                'Ten_Nguyen_Lieu' => $data['Ten_Nguyen_Lieu'],
                'Mo_Ta' => $Mo_Ta,
                'Don_Vi_Tinh' => $data['Don_Vi_Tinh'],
                'Barcode' => $data['Barcode'] ?: null,
                'Ma_loai_nguyen_lieu' => $data['Ma_loai_nguyen_lieu']
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

    public function show($code)
    {
        $chi_tiet = $this->factory->createNguyenLieuRepository()->getChiTietPhieuNhap($code);
        $nguyen_lieu = $this->factory->createNguyenLieuRepository()->find($code);

        if (!$nguyen_lieu) {
            Alert::error('Thất bại', 'Không tìm thấy nguyên liệu.');
            return back();
        }

        if ($chi_tiet->isEmpty()) {
            Alert::warning('Thông báo', 'Không có chi tiết phiếu nhập nào liên quan đến nguyên liệu này!')->autoClose(5000);
        }
        return view('nguyenlieu.show', compact('nguyen_lieu', 'chi_tiet'));
    }

    public function edit($code)
    {
        $loai_nguyen_lieu = LoaiNguyenLieu::all();
        $nguyen_lieu = $this->factory->createNguyenLieuRepository()->find($code);

        if ($nguyen_lieu) {
            return view('nguyenlieu.edit', compact('nguyen_lieu', 'loai_nguyen_lieu'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy nguyên liệu, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    public function update(NguyenLieuUpdateRequest $request, $code)
    {
        $data = $request->validated();
        $Mo_Ta = $this->processDescription($data['Mo_Ta'] ?? null);

        $status = $this->factory->createNguyenLieuRepository()->update($code, [
            'Ten_Nguyen_Lieu' => $data['Ten_Nguyen_Lieu'],
            'Mo_Ta' => $Mo_Ta,
            'Don_Vi_Tinh' => $data['Don_Vi_Tinh'],
            'Barcode' => empty($data['Barcode']) ? null : $data['Barcode'],
            'So_Luong_Ton' => $data['So_Luong_Ton'] ?? null,
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

    public function destroy($id)
    {
        $status = $this->factory->createNguyenLieuRepository()->delete($id);
        if ($status) {
            Alert::success('Thành công', 'Xóa thông tin nguyên liệu thành công!');
            return redirect()->route('nguyen-lieu.index');
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
