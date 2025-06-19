<?php

namespace App\Repositories\PhieuNhap;

use App\Repositories\BaseRepository;
use App\Models\ChiTietPhieuNhap;
use App\Models\NguyenLieu;
use Illuminate\Support\Facades\DB;

class PhieuNhapRepository extends BaseRepository implements PhieuNhapRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\PhieuNhap::class;
    }

    public function getAllWithUser()
    {
        return $this->model->with('User')->orderBy('Ngay_Nhap', 'DESC')->get();
    }

    public function getChiTietPhieuNhap($maPhieuNhap)
    {
        return ChiTietPhieuNhap::with('getNguyenLieu')->where('Ma_Phieu_Nhap', $maPhieuNhap)->paginate(10);
    }

    public function createWithChiTiet($attributes, $chiTietData)
    {
        DB::beginTransaction();
        try {
            $phieuNhap = $this->create($attributes);
            foreach ($chiTietData as $chiTiet) {
                if ($chiTiet['Ma_Nguyen_Lieu'] && $chiTiet['So_Luong'] && $chiTiet['Gia_Nhap'] && $chiTiet['Ngay_San_Xuat'] && $chiTiet['Thoi_Gian_Bao_Quan']) {
                    $nguyenLieu = NguyenLieu::where('Ma_Nguyen_Lieu', $chiTiet['Ma_Nguyen_Lieu'])->first();
                    if (!$nguyenLieu) {
                        throw new \Exception('Nguyên liệu không tồn tại: ' . $chiTiet['Ma_Nguyen_Lieu']);
                    }
                    ChiTietPhieuNhap::create([
                        'Ma_Phieu_Nhap' => $phieuNhap->Ma_Phieu_Nhap,
                        'Ma_Nguyen_Lieu' => $chiTiet['Ma_Nguyen_Lieu'],
                        'So_Luong_Nhap' => $chiTiet['So_Luong'],
                        'Gia_Nhap' => $chiTiet['Gia_Nhap'],
                        'Ngay_San_Xuat' => $chiTiet['Ngay_San_Xuat'],
                        'Thoi_Gian_Bao_Quan' => $chiTiet['Thoi_Gian_Bao_Quan'],
                    ]);
                    $nguyenLieu->So_Luong_Ton += $chiTiet['So_Luong'];
                    $nguyenLieu->save();
                } else {
                    throw new \Exception('Dữ liệu không hợp lệ trong chi tiết phiếu nhập');
                }
            }
            DB::commit();
            return $phieuNhap;
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($phieuNhap)) {
                $phieuNhap->delete();
            }
            throw $e;
        }
    }
}
