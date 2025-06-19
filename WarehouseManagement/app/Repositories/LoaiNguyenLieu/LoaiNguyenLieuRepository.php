<?php

namespace App\Repositories\LoaiNguyenLieu;

use App\Repositories\BaseRepository;
use App\Models\NguyenLieu;

class LoaiNguyenLieuRepository extends BaseRepository implements LoaiNguyenLieuRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\LoaiNguyenLieu::class;
    }

    public function getAllSorted()
    {
        return $this->model->orderBy('Ma_Loai_Nguyen_Lieu')->get();
    }

    public function getNguyenLieuByLoai($maLoaiNguyenLieu)
    {
        return NguyenLieu::where('Ma_loai_nguyen_lieu', $maLoaiNguyenLieu)->get();
    }
    public function getCustomData($param = null)
    {
        // Nếu không cần, có thể ném exception hoặc trả về null
        throw new \Exception("Method getCustomData not implemented for NguyenLieuRepository");
        // Hoặc trả về null nếu không có logic
        // return null;
    }
}
