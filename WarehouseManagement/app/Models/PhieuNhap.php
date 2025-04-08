<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuNhap extends Model
{
    use HasFactory;

    protected $table = 'phieu_nhap';

    protected $primaryKey = 'Ma_Phieu_Nhap';

    protected $guarded = [];

    protected $fillable = [
        'Ma_Phieu_Nhap',
        'Ngay_Nhap',
        'Mo_Ta',
        'Tong_Tien',
        'Ma_NCC',
        'ID_user',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'ID_user','id');
    }

    public function getNhaCungCap()
    {
        return $this->belongsTo(NhaCungCap::class, 'Ma_NCC', 'Ma_nha_cung_cap');
    }
}
