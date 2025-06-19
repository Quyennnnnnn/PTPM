<?php

namespace App\Repositories\NguyenLieu;

use App\Repositories\BaseRepository;
use App\Models\ChiTietPhieuNhap;

class NguyenLieuRepository extends BaseRepository implements NguyenLieuRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\NguyenLieu::class;
    }

    public function getChiTietPhieuNhap($maNguyenLieu)
    {
        return ChiTietPhieuNhap::where('Ma_Nguyen_Lieu', $maNguyenLieu)->paginate(10);
    }
}
