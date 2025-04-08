<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NguyenLieu;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietPhieuNhap;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ThongKeExport;
use Illuminate\Support\Facades\DB;

class ThongKeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index(Request $request)
     {
         // Lấy dữ liệu từ form tìm kiếm
         $from_date = $request->input('Ngay_San_Xuat_From');
         $to_date = $request->input('Ngay_San_Xuat_To');
         $ma_ten = $request->input('Ten_Nguyen_Lieu');
         $loai = $request->input('loai', 'Ma_Nguyen_Lieu');
         $sap_xep = $request->input('sap_xep', 'asc');
         $page = $request->get('page', 1);
         //dd($request->sap_xep);
     
         // Khởi tạo query cho nguyên liệu
         $nguyen_lieu_query = NguyenLieu::query();
     
         // Nếu có tìm kiếm theo mã tên hoặc ngày, áp dụng điều kiện
         if ($ma_ten) {
             $nguyen_lieu_query->where('Ten_Nguyen_Lieu', 'like', "%{$ma_ten}%")
                               ->orWhere('Ma_Nguyen_Lieu', 'like', "%{$ma_ten}%");
         }
     
         // Thêm điều kiện về ngày nếu có
         if ($from_date) {
             $nguyen_lieu_query->whereDate('created_at', '>=', $from_date);
         }
         if ($to_date) {
             $nguyen_lieu_query->whereDate('created_at', '<=', $to_date);
         }
     
         // Sắp xếp dữ liệu nếu có yêu cầu
         $nguyen_lieu_query->orderBy($loai, $sap_xep); 
     
         // Lấy danh sách nguyên liệu với phân trang
         $nguyen_lieu = $nguyen_lieu_query->paginate(20);
     
         // Tính toán tổng giá trị nhập/xuất cho từng nguyên liệu
         foreach ($nguyen_lieu as $nl) {
            $nl->tong_gia_tri_nhap = ChiTietPhieuNhap::where('Ma_Nguyen_Lieu', $nl->Ma_Nguyen_Lieu)
                 ->when($from_date, function ($query, $from_date) {
                     return $query->whereDate('created_at', '>=', $from_date);
                 })
                 ->when($to_date, function ($query, $to_date) {
                     return $query->whereDate('created_at', '<=', $to_date);
                 })
                 ->sum(DB::raw('IFNULL(So_Luong_Nhap, 0) * IFNULL(Gia_Nhap, 0)'));
     
            $nl->tong_gia_tri_xuat = ChiTietPhieuXuat::where('Ma_Nguyen_Lieu', $nl->Ma_Nguyen_Lieu)
                 ->when($from_date, function ($query, $from_date) {
                     return $query->whereDate('created_at', '>=', $from_date);
                 })
                 ->when($to_date, function ($query, $to_date) {
                     return $query->whereDate('created_at', '<=', $to_date);
                 })
                 ->sum(DB::raw('IFNULL(So_Luong_Xuat, 0) * IFNULL(Gia_Xuat, 0)'));
            $nl->tong_xuat = ChiTietPhieuXuat::where('Ma_Nguyen_Lieu', $nl->Ma_Nguyen_Lieu)
                 ->when($from_date, function ($query, $from_date) {
                     return $query->whereDate('created_at', '>=', $from_date);
                 })
                 ->when($to_date, function ($query, $to_date) {
                     return $query->whereDate('created_at', '<=', $to_date);
                 })
                 ->sum(DB::raw('IFNULL(So_Luong_Xuat, 0)'));

            $nl->tong_nhap = $nl->tong_xuat + $nl->So_Luong_Ton;
            
         }
         
         // Định dạng lại ngày cho view
         $from_date = $from_date ? Carbon::createFromFormat('Y-m-d', $from_date)->format('m/d/Y') : '';
         $to_date = $to_date ? Carbon::createFromFormat('Y-m-d', $to_date)->format('m/d/Y') : '';
          //dd($nguyen_lieu);
         // Trả về view với dữ liệu nguyen_lieu
         return view('thongke.index', compact('nguyen_lieu', 'loai', 'sap_xep', 'from_date', 'to_date', 'ma_ten'));
     }
     
    

 
}
