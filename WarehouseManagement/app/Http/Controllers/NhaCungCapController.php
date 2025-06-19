<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Factories\RepositoryFactory;

class NhaCungCapController extends Controller
{
    protected $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index()
    {
        $nha_cung_cap = $this->factory->createNhaCungCapRepository()->getAll();
        return view('nhacungcap.index', compact('nha_cung_cap'));
    }

    public function create()
    {
        $Ma_nha_cung_cap = \App\Models\NhaCungCap::generateMaNCC();
        return view('nhacungcap.create', compact('Ma_nha_cung_cap'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Ma_Nha_Cung_Cap' => 'required',
            'Ten_Nha_Cung_Cap' => 'required|max:100',
            'SDT' => 'required|regex:/^(0)[0-9]{9}$/',
            'Dia_Chi' => 'string|max:255'
        ]);
        $data['Mo_Ta'] = $this->processDescription($request->Mo_Ta);

        $nha_cung_cap = $this->factory->createNhaCungCapRepository()->create($data);

        if ($nha_cung_cap) {
            Alert::success('Thành công', 'Thêm mới nhà cung cấp thành công!');
            return redirect()->route('nha-cung-cap.index');
        } else {
            Alert::error('Thất bại', 'Thêm mới thất bại do đã tồn tại nhà cung cấp từ trước hoặc do lỗi!')->autoClose(5000);
            return back();
        }
    }

    public function show($code)
    {
        $nha_cung_cap = $this->factory->createNhaCungCapRepository()->find($code);
        $chi_tiet_nhap_hang = $this->factory->createNhaCungCapRepository()->getChiTietNhapHang($code);
        $tong_gia_tri = 0;
        foreach ($chi_tiet_nhap_hang as $phieu) {
            $tong_gia_tri += $phieu->chiTietPhieuNhap->sum(function ($chi_tiet) {
                return $chi_tiet->so_luong * $chi_tiet->gia_nhap;
            });
        }
        $nha_cung_cap->tong_gia_tri_hang_hoa = $tong_gia_tri;
        return view('nhacungcap.show', compact('nha_cung_cap', 'chi_tiet_nhap_hang'));
    }

    public function edit($code)
    {
        $nha_cung_cap = $this->factory->createNhaCungCapRepository()->find($code);
        if ($nha_cung_cap) {
            return view('nhacungcap.edit', compact('nha_cung_cap'));
        } else {
            Alert::error('Thất bại', 'Không tìm thấy nhà cung cấp, xin vui lòng thử lại sau!')->autoClose(5000);
            return back();
        }
    }

    public function update(Request $request, $code)
    {
        $request->validate([
            'Ma_Nha_Cung_Cap' => 'required|max:50',
            'Ten_Nha_Cung_Cap' => 'required|max:100',
            'Dia_Chi' => 'string|max:255',
            'SDT' => 'required|regex:/^(0)[0-9]{9}$/'
        ], [
            'SDT.required' => 'Bạn cần thêm số điện thoại!',
            'SDT.regex' => 'Định dạng số điện thoại không đúng.'
        ]);

        $data = $request->all();
        $data['Mo_Ta'] = $this->processDescription($request->Mo_Ta);

        $status = $this->factory->createNhaCungCapRepository()->update($code, $data);

        if ($status) {
            Alert::success('Thành công', 'Sửa thông tin nhà cung cấp thành công!');
            return redirect()->route('nha-cung-cap.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình chỉnh sửa. Xin vui lòng thử lại!')->autoClose(5000);
            return back();
        }
    }

    public function destroy($code)
    {
        $status = $this->factory->createNhaCungCapRepository()->delete($code);
        if ($status) {
            Alert::success('Thành công', 'Xóa thông tin nhà cung cấp thành công!');
            return redirect()->route('nha-cung-cap.index');
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
