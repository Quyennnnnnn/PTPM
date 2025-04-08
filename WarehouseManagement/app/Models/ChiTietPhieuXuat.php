<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietPhieuXuat extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_phieu_xuat';

    public $timestamps = true;

    protected $guarded = [];

    protected $fillable = [
        'Ma_Phieu_Xuat',
        'Ma_Nguyen_Lieu',
        'So_Luong_Xuat',
        'Gia_Xuat',
    ];

    public function getXuatKho()
    {
        return $this->belongsTo(PhieuXuat::class, 'Ma_Phieu_Xuat', 'Ma_Phieu_Xuat');
    }

    public function getNguyenLieu()
    {
        return $this->belongsTo(NguyenLieu::class, 'Ma_Nguyen_Lieu', 'Ma_Nguyen_Lieu');
    }
}
