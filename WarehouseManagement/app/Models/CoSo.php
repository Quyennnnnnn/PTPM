<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoSo extends Model
{
    use HasFactory;

    protected $table = 'co_so';

    protected $primaryKey = 'Ma_Co_So';

    public $timestamps = true;

    protected $guarded = [];

    protected $fillable = [
        'Ma_Co_So',
        'Ten_Co_So',
        'Mo_Ta',
        'Trang_Thai',
    ];
}
