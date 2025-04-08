<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuNhap extends Model
{
    use HasFactory;

    protected $table = "chi_tiet_phieu_nhap";

    public $timestamps = true;

    protected $guarded = [];

    protected $fillable = [
        'Ma_Phieu_Nhap',
        'Ma_Nguyen_Lieu',
        'So_Luong_Nhap',
        'Gia_Nhap',
        'Ngay_San_Xuat',
        'Thoi_Gian_Bao_Quan',
    ];
    public function getNguyenLieu()
    {
        return $this->belongsTo(NguyenLieu::class, 'Ma_Nguyen_Lieu', 'Ma_Nguyen_Lieu');
    }
}
