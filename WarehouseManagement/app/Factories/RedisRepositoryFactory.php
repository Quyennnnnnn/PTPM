<?php

namespace App\Factories;

use App\Repositories\CoSo\CoSoRepositoryInterface;
use App\Repositories\NguyenLieu\NguyenLieuRepositoryInterface;
use App\Repositories\LoaiNguyenLieu\LoaiNguyenLieuRepositoryInterface;
use App\Repositories\NhaCungCap\NhaCungCapRepositoryInterface;
use App\Repositories\PhieuNhap\PhieuNhapRepositoryInterface;
use App\Repositories\PhieuXuat\PhieuXuatRepositoryInterface;
use App\Repositories\ThongKe\ThongKeRepositoryInterface;

class RedisRepositoryFactory extends RepositoryFactory
{
    public function createCoSoRepository(): CoSoRepositoryInterface
    {
        throw new \Exception('Redis CoSoRepository not implemented yet.');
    }

    public function createNguyenLieuRepository(): NguyenLieuRepositoryInterface
    {
        throw new \Exception('Redis NguyenLieuRepository not implemented yet.');
    }

    public function createLoaiNguyenLieuRepository(): LoaiNguyenLieuRepositoryInterface
    {
        throw new \Exception('Redis LoaiNguyenLieuRepository not implemented yet.');
    }

    public function createNhaCungCapRepository(): NhaCungCapRepositoryInterface
    {
        throw new \Exception('Redis NhaCungCapRepository not implemented yet.');
    }

    public function createPhieuNhapRepository(): PhieuNhapRepositoryInterface
    {
        throw new \Exception('Redis PhieuNhapRepository not implemented yet.');
    }

    public function createPhieuXuatRepository(): PhieuXuatRepositoryInterface
    {
        throw new \Exception('Redis PhieuXuatRepository not implemented yet.');
    }

    public function createThongKeRepository(): ThongKeRepositoryInterface
    {
        throw new \Exception('Redis ThongKeRepository not implemented yet.');
    }
}
