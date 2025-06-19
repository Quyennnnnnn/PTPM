<?php

namespace App\Repositories\ThongKe;

use App\Repositories\BaseRepository;
use App\Models\NguyenLieu;
use App\Models\ChiTietPhieuNhap;
use App\Models\ChiTietPhieuXuat;
use Illuminate\Support\Facades\DB;

class ThongKeRepository extends BaseRepository implements ThongKeRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\NguyenLieu::class;
    }

    public function getNguyenLieuWithStats($request)
    {
        $from_date = $request->input('Ngay_San_Xuat_From');
        $to_date = $request->input('Ngay_San_Xuat_To');
        $ma_ten = $request->input('Ten_Nguyen_Lieu');
        $loai = $request->input('loai', 'Ma_Nguyen_Lieu');
        $sap_xep = $request->input('sap_xep', 'asc');

        $query = $this->model->query();

        if ($ma_ten) {
            $query->where('Ten_Nguyen_Lieu', 'like', "%{$ma_ten}%")
                ->orWhere('Ma_Nguyen_Lieu', 'like', "%{$ma_ten}%");
        }

        if ($from_date) {
            $query->whereDate('created_at', '>=', $from_date);
        }
        if ($to_date) {
            $query->whereDate('created_at', '<=', $to_date);
        }

        $query->orderBy($loai, $sap_xep);
        $nguyen_lieu = $query->paginate(20);

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

        return $nguyen_lieu;
    }
}
