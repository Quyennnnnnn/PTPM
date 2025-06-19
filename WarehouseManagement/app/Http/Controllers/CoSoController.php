<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\RepositoryFactory;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CoSoController extends Controller
{
    protected $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index()
    {
        $co_so = $this->factory->createCoSoRepository()->getAll();
        return view('coso.index', compact('co_so'));
    }

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Ma_Co_So' => 'required|string|max:50|unique:co_so,Ma_Co_So',
            'Ten_Co_So' => 'required|string|max:100',
            'Mo_Ta' => 'nullable|string',
            'Trang_Thai' => 'required|in:Hoat_Dong,Ngung_Hoat_Dong'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['Mo_Ta'] = $this->processDescription($data['Mo_Ta'] ?? null);

        $this->factory->createCoSoRepository()->create($data);

        Alert::success('Thành công', 'Thêm mới cơ sở thành công!');
        return redirect()->route('co-so.index');
    }

    public function show($id)
    {
        $co_so = $this->factory->createCoSoRepository()->find($id);
        if (!$co_so) {
            Alert::error('Thất bại', 'Không tìm thấy cơ sở.');
            return back();
        }
        return view('coso.show', compact('co_so'));
    }

    public function edit($id)
    {
        $co_so = $this->factory->createCoSoRepository()->find($id);
        if (!$co_so) {
            Alert::error('Thất bại', 'Không tìm thấy cơ sở.');
            return back();
        }
        return view('coso.edit', compact('co_so'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Ma_Co_So' => 'required|string|max:50|unique:co_so,Ma_Co_So,' . $id . ',Ma_Co_So',
            'Ten_Co_So' => 'required|string|max:100',
            'Mo_Ta' => 'nullable|string',
            'Trang_Thai' => 'required|in:Hoat_Dong,Ngung_Hoat_Dong'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $data['Mo_Ta'] = $this->processDescription($data['Mo_Ta'] ?? null);

        $status = $this->factory->createCoSoRepository()->update($id, $data);

        if ($status) {
            Alert::success('Thành công', 'Cập nhật cơ sở thành công!');
            return redirect()->route('co-so.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình cập nhật.');
            return back();
        }
    }

    public function destroy($id)
    {
        $status = $this->factory->createCoSoRepository()->delete($id);
        if ($status) {
            Alert::success('Thành công', 'Xóa cơ sở thành công!');
            return redirect()->route('co-so.index');
        } else {
            Alert::error('Thất bại', 'Có lỗi trong quá trình xóa.');
            return back();
        }
    }
}
