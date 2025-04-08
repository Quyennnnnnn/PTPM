<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
    use HasFactory;

    protected $table = 'nha_cung_cap';

    // Chỉ định rõ các thuộc tính có thể gán
    protected $fillable = [
        'Ma_Nha_Cung_Cap',
        'Ten_Nha_Cung_Cap',
        'Dia_Chi',
        'SDT',
        'Mo_Ta'
    ];

    protected $primaryKey = 'Ma_nha_cung_cap';
    public static function generateMaNCC()
    {
        do {
            $randomNumber = rand(10000, 99999);
            
        } while (self::where('Ma_nha_cung_cap', $randomNumber)->exists());
    
        return $randomNumber;
    }

    public $incrementing = true;
}
