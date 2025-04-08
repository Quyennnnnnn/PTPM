<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhieuXuat extends Model
{
    use HasFactory;

    protected $table = 'phieu_xuat';

    protected $primaryKey = 'Ma_Phieu_Xuat';

    protected $guarded = [];

    protected $fillable = [
        'Ma_Phieu_Xuat',
        'Ngay_Xuat',
        'Mo_Ta',
        'Tong_Tien',
        'Ma_Co_So',
        'ID_user',
    ];

    public function getCoSo()
    {
        return $this->belongsTo(CoSo::class, 'Ma_Co_So','Ma_Co_So');
    }


    public function getUser()
    {
        return $this->belongsTo(User::class, 'ID_user','id');
    }
}
