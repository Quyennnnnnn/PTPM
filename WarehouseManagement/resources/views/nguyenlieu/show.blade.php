@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Thông tin</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        <li class="breadcrumb-item"><a href="{{ route('nguyen-lieu.index') }}">Quản lý kho</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">{{$nguyen_lieu->Ten_Nguyen_Lieu }}</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                               
                                    <ul class="d-flex">
                                        <li>
                                            <a href="{{ route('nguyen-lieu.edit', $nguyen_lieu->Ma_Nguyen_Lieu) }}" class="btn btn-primary btn-md d-md-none"><em class="icon ni ni-edit"></em></em><span>Sửa</span></a>
                                        </li>
                                        <li>
                                            <a href="{{ route('nguyen-lieu.edit', $nguyen_lieu->Ma_Nguyen_Lieu) }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-edit"></em><span>Sửa thông tin</span></a>
                                        </li>
                                    </ul>
                               
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        
                        <div class="col-md-6 card mb-5">
                            <div class="card-body">
                                <h4 class="bio-block-title">Chi tiết</h4>
                                <ul class="list-group list-group-borderless small">
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mã nguyên liệu:</span><span class="text">{{ $nguyen_lieu->Ma_Nguyen_Lieu }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Tên nguyên liệu:</span><span class="text">{{ $nguyen_lieu->Ten_Nguyen_Lieu }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Loại nguyên liệu:</span><span class="text">{{ $nguyen_lieu->LoaiNguyenLieu->Ten_Loai_Nguyen_Lieu }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Đơn vị:</span><span class="text">{{ $nguyen_lieu->Don_Vi_Tinh }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Barcode:</span><span class="text">{{ $nguyen_lieu->Barcode }}</span>
                                    </li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Số lượng tồn kho:</span><span class="text"> {{ $nguyen_lieu->So_Luong_Ton }}</span></li>
                                    <li class="list-group-item"><span class="title fw-medium w-40 d-inline-block">Mô tả:</span><span class="text"> {{ $nguyen_lieu->Mo_Ta }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nk-block">
                    <div class="card">
                        <table class="table" data-nk-container="table-responsive" id="nguyen-lieu">
                            <thead class="table-light">
                                <tr>
                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                    <th class="tb-col"><span class="overline-title">Giá nhập</span></th>
                                    <th class="tb-col"><span class="overline-title">Ngày sản xuất</span></th>
                                    <th class="tb-col"><span class="overline-title">Bảo quản(tháng)</span>
                                    <th class="tb-col"><span class="overline-title">Hạn sử dụng</span>
                                    <th class="tb-col"><span class="overline-title">Thành tiền</span>
                                    </th>
                                    <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    use Carbon\Carbon;
                                @endphp
                                @foreach ($chi_tiet as $key => $ct)
                                    @php
                                        // Định dạng giá nhập và tính thành tiền
                                        $gia_nhap = number_format($ct->Gia_Nhap, 0, '', '.');
                                        $thanh_tien = number_format($ct->So_Luong_Nhap * $ct->Gia_Nhap, 0, '', '.');

                                        // Xử lý ngày sản xuất và thời gian bảo quản
                                        $date = Carbon::parse($ct->Ngay_San_Xuat);
                                        $date->addMonths($ct->Thoi_Gian_Bao_Quan);
                                        $diffDays = Carbon::now()->diffInDays($date, false);
                                        $ngay_san_xuat = Carbon::createFromFormat('Y-m-d', $ct->Ngay_San_Xuat)->format('d-m-Y');
                                    @endphp
                                    <tr>
                                        <td class="tb-col">
                                            <span>{{ $key + 1 }}</span>
                                        </td>
                                        <td class="tb-col"><span>{{ $ct->So_Luong_Nhap }}</span></td>
                                        <td class="tb-col"><span>{{ $gia_nhap }} VNĐ</span></td>
                                        <td class="tb-col"><span>{{ $ngay_san_xuat }}</span></td>
                                        <td class="tb-col"><span>{{ $ct->Thoi_Gian_Bao_Quan }}</span></td>
                                        <td class="tb-col">
                                            @if ($diffDays > 30)
                                                <span class="badge text-bg-success-soft">Còn {{ $diffDays }} ngày</span>
                                            @elseif ($diffDays <= 30 && $diffDays > 0)
                                                <span class="badge text-bg-warning-soft">Còn {{ $diffDays }} ngày</span>
                                            @else
                                                <span class="badge text-bg-danger-soft">Hết hạn {{ abs($diffDays) }} ngày</span>
                                            @endif
                                        </td>
                                        <td class="tb-col">
                                            <span>{{ $thanh_tien }} VNĐ</span>
                                        </td>
                                        <td class="tb-col tb-col-end">
                                            <a class="btn btn-info btn-sm" href="{{ route('nhap-kho.show', $ct->Ma_Phieu_Nhap) }}">
                                                <em class="icon ni ni-eye"></em><span>Xem</span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                @include('parts.paginate', ['paginator' => $chi_tiet])
            </div>
        </div>
    </div>
    </div>
@endsection


@section('script')
@endsection
