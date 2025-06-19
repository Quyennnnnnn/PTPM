<?php

namespace App\Repositories\PhieuXuat;

use App\Repositories\BaseRepository;
use App\Models\ChiTietPhieuXuat;
use App\Models\NguyenLieu;
use Illuminate\Support\Facades\DB;

class PhieuXuatRepository extends BaseRepository implements PhieuXuatRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\PhieuXuat::class;
    }

    public function getAllWithUser()
    {
        return $this->model->with('getUser')->orderBy('Ma_Phieu_Xuat', 'DESC')->paginate(10);
    }

    public function getChiTietPhieuXuat($maPhieuXuat)
    {
        return ChiTietPhieuXuat::where('Ma_Phieu_Xuat', $maPhieuXuat)->paginate(10);
    }

    public function createWithChiTiet($attributes, $chiTietData)
    {
        DB::beginTransaction();
        try {
            $phieuXuat = $this->create($attributes);
            foreach ($chiTietData as $chiTiet) {
                if ($chiTiet['Ma_Nguyen_Lieu'] && $chiTiet['So_Luong_Xuat'] && $chiTiet['Gia_Xuat']) {
                    $nguyenLieu = NguyenLieu::where('Ma_Nguyen_Lieu', $chiTiet['Ma_Nguyen_Lieu'])->first();
                    if (!$nguyenLieu) {
                        throw new \Exception('Nguyên liệu không tồn tại: ' . $chiTiet['Ma_Nguyen_Lieu']);
                    }
                    ChiTietPhieuXuat::create([
                        'Ma_Phieu_Xuat' => $phieuXuat->Ma_Phieu_Xuat,
                        'Ma_Nguyen_Lieu' => $chiTiet['Ma_Nguyen_Lieu'],
                        'So_Luong_Xuat' => $chiTiet['So_Luong_Xuat'],
                        'Gia_Xuat' => $chiTiet['Gia_Xuat'],
                    ]);
                    $nguyenLieu->So_Luong_Ton -= $chiTiet['So_Luong_Xuat'];
                    $nguyenLieu->save();
                } else {
                    throw new \Exception('Dữ liệu không hợp lệ trong chi tiết phiếu xuất');
                }
            }
            DB::commit();
            return $phieuXuat;
        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($phieuXuat)) {
                $phieuXuat->delete();
            }
            throw $e;
        }
    }
}
