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
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('xuat-kho.index') }}">Quản lý xuất kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $phieu_xuat->ma_phieu_xuat }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <div class="nk-invoice">
                                <div class="nk-invoice-head flex-column flex-sm-row">
                                    <div class="nk-invoice-head-item mb-3 mb-sm-0">
                                        <div class="h4">Chi tiết</div>
                                        <ul>
                                            <li>Nhân viên: {{ $phieu_xuat->getUser->Name }}</li>
                                            <li>Cơ sở: {{ $phieu_xuat->getCoso->Ten_Co_So }}</li>
                                            <li>Mô tả: {{ $phieu_xuat->Mo_Ta }}</li>
                                        </ul>
                                    </div>
                                    <div class="nk-invoice-head-item text-sm-end">
                                        <div class="h3">Mã phiếu xuất: {{ $phieu_xuat->ma_phieu_xuat }}</div>
                                        <ul>
                                            <li>Ngày xuất: {{ \Carbon\Carbon::createFromFormat('Y-m-d', $phieu_xuat->Ngay_Xuat)->format('d-m-Y') }}</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="nk-invoice-body">
                                    <div class="table-responsive">
                                        <table class="table nk-invoice-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                                    <th class="tb-col"><span class="overline-title">Mã hàng hóa</span></th>
                                                    <th class="tb-col"><span class="overline-title">Tên hàng hóa</span></th>
                                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                                    <th class="tb-col"><span class="overline-title">Giá xuất</span></th>
                                                    <th class="tb-col tb-col-end"><span class="overline-title">Thành tiền</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $result = 0;
                                                @endphp

                                                @foreach ($chi_tiet_phieu_xuat as $key => $chi_tiet)
                                                    @php
                                                        $price = $chi_tiet->So_Luong_Xuat * $chi_tiet->Gia_Xuat;
                                                        $result += $price;
                                                    @endphp
                                                    <tr>
                                                        <td class="tb-col">
                                                            <span>{{ $key + 1 }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->getNguyenLieu->Ma_Nguyen_Lieu }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->getNguyenLieu->Ten_Nguyen_Lieu }}</span>
                                                        </td>
                                                        <td class="tb-col"><span>{{ $chi_tiet->So_Luong_Xuat }}</span></td>
                                                        <td class="tb-col"><span>{{ number_format($chi_tiet->Gia_Xuat, 0, '', '.') }} VNĐ</span></td>
                                                        <td class="tb-col tb-col-end"><span>{{ number_format($price, 0, '', '.') }} VNĐ</span></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td colspan="">Tổng:</td>
                                                    <td class="tb-col tb-col-end">{{ number_format($result, 0, '', ',') }} VNĐ</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @include('parts.paginate', ['paginator' => $chi_tiet_phieu_xuat])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
