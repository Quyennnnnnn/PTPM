<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChiTietPhieuXuat;
use App\Models\ChiTietPhieuNhap;
use App\Models\LoaiNguyenLieu;
use App\Models\NguyenLieu;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = date('Y-m-d');

        $tien_xuat_kho = ChiTietPhieuXuat::whereDate('created_at', $today)
        ->selectRaw('SUM(So_Luong_Xuat * Gia_Xuat) as thanh_tien')
        ->value('thanh_tien') ?? 0;
    
        $tien_nhap_kho = ChiTietPhieuNhap::whereDate('created_at', $today)
            ->selectRaw('SUM(So_Luong_Nhap * Gia_Nhap) as tong_tien')
            ->value('tong_tien') ?? 0;
        
        $so_luong_nguyen_lieu = NguyenLieu::count();
        $so_luong_loai_nguyen_lieu =LoaiNguyenLieu::count();
        // dd($so_luong_nguyen_lieu);


        $so_luong_het_hang = NguyenLieu::where('So_Luong_Ton', 0)->count();

        $so_luong_xuat = DB::table('chi_tiet_phieu_xuat') 
        ->join('nguyen_lieu', 'chi_tiet_phieu_xuat.Ma_Nguyen_Lieu', '=', 'nguyen_lieu.Ma_Nguyen_Lieu') 
        ->select(
            'chi_tiet_phieu_xuat.Ma_Nguyen_Lieu', 
            'nguyen_lieu.Ten_Nguyen_Lieu',       
            DB::raw('SUM(chi_tiet_phieu_xuat.So_Luong_Xuat) as Tong_Luong_Xuat'), 
            DB::raw('SUM(chi_tiet_phieu_xuat.So_Luong_Xuat * chi_tiet_phieu_xuat.Gia_Xuat) as Tong_Tien_Xuat') 
        )
        ->groupBy('chi_tiet_phieu_xuat.Ma_Nguyen_Lieu', 'nguyen_lieu.Ten_Nguyen_Lieu') 
        ->orderBy('Tong_Luong_Xuat', 'desc')
        ->get();
        // dd($so_luong_xuat);
        return view('dashboard', compact('so_luong_nguyen_lieu', 'so_luong_het_hang', 'tien_nhap_kho', 'tien_xuat_kho','so_luong_loai_nguyen_lieu','so_luong_xuat'));
    }

    public function thongKeNhapXuatHangThang()
    {
        // Thời gian bắt đầu là 11 tháng trước và kết thúc là tháng hiện tại
        $start = Carbon::now()->subMonths(11)->startOfMonth();
        $end = Carbon::now()->endOfMonth();

        // Truy vấn tổng giá trị nhập kho theo từng tháng
        $nhap_kho = ChiTietPhieuNhap::selectRaw('MONTH(created_at) as month, SUM(So_Luong_Nhap * Gia_Nhap) as tong_nhap')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Truy vấn tổng giá trị xuất kho theo từng tháng
        $xuat_kho = ChiTietPhieuXuat::selectRaw('MONTH(created_at) as month, SUM(So_Luong_Xuat * Gia_Xuat) as tong_xuat')
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Khởi tạo mảng nhãn và giá trị nhập/xuất cho biểu đồ
        $labels = [];
        $nhap_values = [];
        $xuat_values = [];

        // Lặp qua 12 tháng để tạo nhãn và giá trị nhập, xuất cho từng tháng
        for ($i = 0; $i < 12; $i++) {
            $month = $start->copy()->addMonths($i)->format('m'); // Lấy tháng theo định dạng 01, 02, ..., 12
            $labels[] = $month; // Lưu tháng vào nhãn

            // Tìm giá trị nhập kho cho tháng hiện tại, nếu không có dữ liệu thì gán 0
            $nhap = $nhap_kho->where('month', $month)->first();
            $nhap_values[] = $nhap ? $nhap->tong_nhap : 0;

            // Tìm giá trị xuất kho cho tháng hiện tại, nếu không có dữ liệu thì gán 0
            $xuat = $xuat_kho->where('month', $month)->first();
            $xuat_values[] = $xuat ? $xuat->tong_xuat : 0;
        }

        // Trả về dữ liệu dưới dạng JSON để dùng cho biểu đồ frontend
        return response()->json([
            'labels' => $labels,
            'nhap_values' => $nhap_values,
            'xuat_values' => $xuat_values,
        ]);
    }
}
