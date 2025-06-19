<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\RepositoryFactory;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ThongKeExport;

class ThongKeController extends Controller
{
    protected $factory;

    public function __construct(RepositoryFactory $factory)
    {
        $this->factory = $factory;
    }

    public function index(Request $request)
    {
        $nguyen_lieu = $this->factory->createThongKeRepository()->getNguyenLieuWithStats($request);
        $from_date = $request->input('Ngay_San_Xuat_From') ? Carbon::createFromFormat('Y-m-d', $request->input('Ngay_San_Xuat_From'))->format('m/d/Y') : '';
        $$to_date = $request->input('Ngay_San_Xuat_To') ? Carbon::createFromFormat('Y-m-d', $request->input('Ngay_San_Xuat_To'))->format('m/d/Y') : '';
        $loai = $request->input('loai', 'Ma_Nguyen_Lieu');
        $sap_xep = $request->input('sap_xep', 'asc');
        $ma_ten = $request->input('Ten_Nguyen_Lieu');

        return view('thongke.index', compact('nguyen_lieu', 'loai', 'sap_xep', 'from_date', 'to_date', 'ma_ten'));
    }
}
