<?php

namespace App\Repositories\PhieuXuat;

use App\Repositories\RepositoryInterface;

interface PhieuXuatRepositoryInterface extends RepositoryInterface
{
    public function getAllWithUser();
    public function getChiTietPhieuXuat($maPhieuXuat);
    public function createWithChiTiet($attributes, $chiTietData);
}
