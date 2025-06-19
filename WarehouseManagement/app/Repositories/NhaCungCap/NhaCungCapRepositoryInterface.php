<?php

namespace App\Repositories\NhaCungCap;

use App\Repositories\RepositoryInterface;

interface NhaCungCapRepositoryInterface extends RepositoryInterface
{
    public function getChiTietNhapHang($maNhaCungCap);
}
