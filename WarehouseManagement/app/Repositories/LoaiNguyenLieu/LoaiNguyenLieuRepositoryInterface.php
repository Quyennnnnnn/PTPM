<?php

namespace App\Repositories\LoaiNguyenLieu;

use App\Repositories\RepositoryInterface;

interface LoaiNguyenLieuRepositoryInterface extends RepositoryInterface
{
    public function getAllSorted();
    public function getNguyenLieuByLoai($maLoaiNguyenLieu);
}
