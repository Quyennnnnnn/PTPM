<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ExcelRequest;
use App\Imports\NguyenLieuImport;
use Maatwebsite\Excel\Facades\Excel;

class NguyenLieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function import(ExcelRequest $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new NguyenLieuImport(), $file);


        return response()->json(['message' => 'Nhập nguyên liệu thành công!', 'type' => 'success', 'redirect' => route('nguyen-lieu.index')]);
    }
}
