<?php

namespace App\Repositories\NguyenLieu;

use App\Repositories\RepositoryInterface;

interface NguyenLieuRepositoryInterface extends RepositoryInterface
{
    public function getChiTietPhieuNhap($maNguyenLieu);
}
