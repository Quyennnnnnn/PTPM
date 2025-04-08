<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoSo;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CoSoController extends Controller
{
    // Hiển thị danh sách tất cả cơ sở
    public function index()
    {
        $co_so = CoSo::all();
        return view('coso.index', compact('co_so'));
    }

    // Hiển thị form để tạo cơ sở mới
    public function create()
    {
        return view('coso.create');
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
    // Lưu cơ sở mới vào cơ sở dữ liệu
    public function store(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'Ma_Co_So' => 'required|string|max:50|unique:co_so,Ma_Co_So',
            'Ten_Co_So' => 'required|string|max:100',
            'Mo_Ta' => 'nullable|string',
            'Trang_Thai' => 'required|in:Hoat_Dong,Ngung_Hoat_Dong'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Xử lý mô tả trước khi lưu
        $data = $request->all();
        $data['Mo_Ta'] = $this->processDescription($data['Mo_Ta'] ?? null);

        // Tạo mới cơ sở
        CoSo::create($data);

        Alert::success('Thành công', 'Thêm mới cơ sở thành công!');
        return redirect()->route('co-so.index');
    }


    // Hiển thị thông tin chi tiết của một cơ sở
    public function show($id)
    {
        $co_so = CoSo::findOrFail($id);
        return view('coso.show', compact('co_so'));
    }

    // Hiển thị form để chỉnh sửa một cơ sở
    public function edit($id)
    {
        $co_so = CoSo::findOrFail($id);
        return view('coso.edit', compact('co_so'));
    }

    // Cập nhật thông tin cơ sở vào cơ sở dữ liệu
    public function update(Request $request, $id)
{
    // Xác thực dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'Ma_Co_So' => 'required|string|max:50|unique:co_so,Ma_Co_So,' . $id . ',Ma_Co_So',
        'Ten_Co_So' => 'required|string|max:100',
        'Mo_Ta' => 'nullable|string',
        'Trang_Thai' => 'required|in:Hoat_Dong,Ngung_Hoat_Dong'
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Xử lý mô tả trước khi cập nhật
    $data = $request->all();
    $data['Mo_Ta'] = $this->processDescription($data['Mo_Ta'] ?? null);

    // Cập nhật cơ sở
    $co_so = CoSo::findOrFail($id);
    $co_so->update($data);

    Alert::success('Thành công', 'Cập nhập cơ sở thành công!');
    return redirect()->route('co-so.index');
}


    // Xóa một cơ sở khỏi cơ sở dữ liệu
    public function destroy($id)
    {
        $co_so = CoSo::findOrFail($id);
        $co_so->delete();
        Alert::success('Thành công', 'Xoá cơ sở thành công!');
        return redirect()->route('co-so.index');
    }
}
