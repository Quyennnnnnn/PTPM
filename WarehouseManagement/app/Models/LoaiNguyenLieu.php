<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiNguyenLieu extends Model
{
    use HasFactory;

    protected $table = 'loai_nguyen_lieu';

    protected $primaryKey = 'Ma_Loai_Nguyen_Lieu';

    protected $guarded = [];

    protected $fillable = [
        'Ma_Loai_Nguyen_Lieu',
        'Ten_Loai_Nguyen_Lieu',
        'Mo_Ta',
    ];

    public function nguyenLieu()
    {
        return $this->hasMany(NguyenLieu::class, 'Ma_loai_nguyen_lieu', 'Ma_Loai_Nguyen_Lieu');
    }
    public static function generateMaLoaiNguyenLieu()
    {
        do {
            $randomNumber = rand(10000, 99999);
            
        } while (self::where('Ma_Loai_Nguyen_Lieu', $randomNumber)->exists()); 
    
        return $randomNumber;
    }

}
