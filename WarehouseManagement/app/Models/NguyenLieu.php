<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Thêm dòng này để sử dụng Str::random

class NguyenLieu extends Model
{
    use HasFactory;

    protected $table = 'nguyen_lieu';

    protected $primaryKey = 'Ma_Nguyen_Lieu';
    protected $fillable = [
        'Ma_Nguyen_Lieu', // Thêm trường này vào
        'Ten_Nguyen_Lieu',
        'Mo_Ta',
        'Don_Vi_Tinh',
        'Barcode',
        'So_Luong_Ton',
        'Ma_loai_nguyen_lieu',
    ];
    public $incrementing = true;
    // Định nghĩa quan hệ với LoaiNguyenLieu
    public function loaiNguyenLieu()
    {
        return $this->belongsTo(LoaiNguyenLieu::class, 'Ma_loai_nguyen_lieu', 'Ma_Loai_Nguyen_Lieu');
    }

    public static function generateMaNguyenLieu()
    {
        do {
            // Sinh một số ngẫu nhiên trong khoảng từ 10000 đến 99999
            $randomNumber = rand(10000, 99999);
            
        } while (self::where('Ma_Nguyen_Lieu', $randomNumber)->exists()); // Kiểm tra mã đã tồn tại chưa
    
        return $randomNumber;
    }
}
