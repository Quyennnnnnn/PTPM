<?php

namespace App\Factories;

use App\Repositories\CoSo\CoSoRepository;
use App\Repositories\CoSo\CoSoRepositoryInterface;
use App\Repositories\NguyenLieu\NguyenLieuRepository;
use App\Repositories\NguyenLieu\NguyenLieuRepositoryInterface;
use App\Repositories\LoaiNguyenLieu\LoaiNguyenLieuRepository;
use App\Repositories\LoaiNguyenLieu\LoaiNguyenLieuRepositoryInterface;
use App\Repositories\NhaCungCap\NhaCungCapRepository;
use App\Repositories\NhaCungCap\NhaCungCapRepositoryInterface;
use App\Repositories\PhieuNhap\PhieuNhapRepository;
use App\Repositories\PhieuNhap\PhieuNhapRepositoryInterface;
use App\Repositories\PhieuXuat\PhieuXuatRepository;
use App\Repositories\PhieuXuat\PhieuXuatRepositoryInterface;
use App\Repositories\ThongKe\ThongKeRepository;
use App\Repositories\ThongKe\ThongKeRepositoryInterface;

class MySQLRepositoryFactory extends RepositoryFactory
{
    public function createCoSoRepository(): CoSoRepositoryInterface
    {
        return new CoSoRepository();
    }

    public function createNguyenLieuRepository(): NguyenLieuRepositoryInterface
    {
        return new NguyenLieuRepository();
    }

    public function createLoaiNguyenLieuRepository(): LoaiNguyenLieuRepositoryInterface
    {
        return new LoaiNguyenLieuRepository();
    }

    public function createNhaCungCapRepository(): NhaCungCapRepositoryInterface
    {
        return new NhaCungCapRepository();
    }

    public function createPhieuNhapRepository(): PhieuNhapRepositoryInterface
    {
        return new PhieuNhapRepository();
    }

    public function createPhieuXuatRepository(): PhieuXuatRepositoryInterface
    {
        return new PhieuXuatRepository();
    }

    public function createThongKeRepository(): ThongKeRepositoryInterface
    {
        return new ThongKeRepository();
    }
}
