<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PhieuXuat;
use App\Models\ChiTietPhieuXuat;
use App\Models\NguyenLieu;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class XuatKhoController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('searchInput');
        $selectedValues = $request->input('selectedValues', []);

        $nguyen_lieu = NguyenLieu::where('Ma_Nguyen_Lieu', 'LIKE', "%{$query}%")
                                    ->orWhere('Ten_Nguyen_Lieu', 'LIKE', "%{$query}%")
                                    ->whereNotIn('Ma_Nguyen_Lieu', $selectedValues)
                                    ->where('So_Luong_Ton', '>', 0)
                                    ->get();
        return response()->json($nguyen_lieu);
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
    $validator = Validator::make($data, [
        'Ma_Phieu_Xuat' => 'required|unique:phieu_xuat,Ma_Phieu_Xuat',
        'Ngay_Xuat' => 'required|date',
        'Mo_Ta' => 'nullable|string|max:255',
        'Ma_Co_So' => 'required',
        'So_Luong' => 'required|array',
        'Gia_Xuat' => 'required|array',
        'Ma_Nguyen_Lieu' => 'required|array',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $tongtien = 0;
    foreach ($data['So_Luong'] as $index => $soLuong) {
        $giaXuat = $data['Gia_Xuat'][$index] ?? 0;

        if ($soLuong <= 0 || $giaXuat <= 0) {
            return response()->json([
                'message' => trans('messages.quantity_price_invalid')
            ], 422);
        }

        $tongtien += $soLuong * $giaXuat;
    }

    DB::beginTransaction();

    // dd($data);
    try {
        $userId = auth()->user()->id;
        $phieu_xuat = PhieuXuat::create([
            'Ma_Phieu_Xuat' => $request->Ma_Phieu_Xuat,
            'Ngay_Xuat' => $data['Ngay_Xuat'],
            'Mo_Ta' => $this->processDescription($data['Mo_Ta'] ?? null),
            'Ma_Co_So' => $data['Ma_Co_So'],
            'Tong_Tien' => $tongtien,
            'ID_user' => $userId,
        ]);

        if (!$phieu_xuat) {
            throw new \Exception(trans('messages.phieu_xuat_creation_failed'));
        }
        foreach ($data['Ma_Nguyen_Lieu'] as $index => $maNguyenLieu) {
            $soLuong = $data['So_Luong'][$index] ?? null;
            $giaXuat = $data['Gia_Xuat'][$index] ?? null;
            if (!$maNguyenLieu || !$soLuong || !$giaXuat) {
                throw new \Exception(trans('messages.detail_data_invalid'));
            }

            $nguyenLieu = NguyenLieu::where('Ma_Nguyen_Lieu', $maNguyenLieu)->first();
            if (!$nguyenLieu) {
                throw new \Exception(trans('messages.nguyen_lieu_not_found'));
            }

            if ($nguyenLieu->So_Luong_Ton < $soLuong) {
                throw new \Exception(trans('messages.not_enough_stock') . " " . $maNguyenLieu);
            }
            ChiTietPhieuXuat::create([
                'Ma_Phieu_Xuat' => $phieu_xuat->Ma_Phieu_Xuat,
                'Ma_Nguyen_Lieu' => $maNguyenLieu,
                'So_Luong_Xuat' => $soLuong,
                'Gia_Xuat' => $giaXuat,
            ]);


            $nguyenLieu->So_Luong_Ton -= $soLuong;
            $nguyenLieu->save();
        }

        DB::commit();

        Alert::success('Thành công', 'Xuất nguyên liệu thành công!');
        return redirect()->back();
    } catch (\Exception $e) {
        DB::rollBack();
        Alert::error('Thất bại', $e->getMessage())->autoClose(5000);
        return redirect()->back();
    }
}


    
}
