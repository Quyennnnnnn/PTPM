<?php

namespace App\Repositories\NhaCungCap;

use App\Repositories\BaseRepository;
use App\Models\PhieuNhap;

class NhaCungCapRepository extends BaseRepository implements NhaCungCapRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\NhaCungCap::class;
    }

    public function getChiTietNhapHang($maNhaCungCap)
    {
        return PhieuNhap::where('Ma_NCC', $maNhaCungCap)->paginate(10);
    }
    public function getChiTietPhieuNhap($code)
    {
        return $this->model->where('Ma_Nguyen_Lieu', $code)->first()->chiTietPhieuNhap ?? collect([]);
    }
}
