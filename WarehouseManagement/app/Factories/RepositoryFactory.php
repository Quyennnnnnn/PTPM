<?php

namespace App\Factories;

use App\Repositories\CoSo\CoSoRepositoryInterface;
use App\Repositories\NguyenLieu\NguyenLieuRepositoryInterface;
use App\Repositories\LoaiNguyenLieu\LoaiNguyenLieuRepositoryInterface;
use App\Repositories\NhaCungCap\NhaCungCapRepositoryInterface;
use App\Repositories\PhieuNhap\PhieuNhapRepositoryInterface;
use App\Repositories\PhieuXuat\PhieuXuatRepositoryInterface;
use App\Repositories\ThongKe\ThongKeRepositoryInterface;

abstract class RepositoryFactory
{
    abstract public function createCoSoRepository(): CoSoRepositoryInterface;
    abstract public function createNguyenLieuRepository(): NguyenLieuRepositoryInterface;
    abstract public function createLoaiNguyenLieuRepository(): LoaiNguyenLieuRepositoryInterface;
    abstract public function createNhaCungCapRepository(): NhaCungCapRepositoryInterface;
    abstract public function createPhieuNhapRepository(): PhieuNhapRepositoryInterface;
    abstract public function createPhieuXuatRepository(): PhieuXuatRepositoryInterface;
    abstract public function createThongKeRepository(): ThongKeRepositoryInterface;
}
