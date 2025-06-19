<?php

namespace App\Repositories\PhieuNhap;

use App\Repositories\RepositoryInterface;

interface PhieuNhapRepositoryInterface extends RepositoryInterface
{
    public function getAllWithUser();
    public function getChiTietPhieuNhap($maPhieuNhap);
    public function createWithChiTiet($attributes, $chiTietData);
}
