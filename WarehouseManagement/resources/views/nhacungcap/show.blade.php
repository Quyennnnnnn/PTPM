@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Xem</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('nha-cung-cap.index') }}">Nhà cung cấp</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $nha_cung_cap->Ten_Nha_Cung_Cap }}</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                               
                                    <ul class="d-flex">
                                        <li><a href="{{ route('nha-cung-cap.edit', $nha_cung_cap->Ma_nha_cung_cap) }}" class="btn btn-primary d-md-inline-flex"><em class="icon ni ni-edit"></em><span>Sửa nhà cung cấp</span></a></li>
                                    </ul>
                                
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
                                            <li>Mã nhà cung cấp: {{ $nha_cung_cap->Ma_nha_cung_cap }}</li>
                                            <li>Tên nhà cung cấp: {{ $nha_cung_cap->Ten_Nha_Cung_Cap }}</li>
                                            <li>Số điện thoại: {{ $nha_cung_cap->SDT }}</li>
                                            <li>Địa chỉ: {{ $nha_cung_cap->Dia_Chi }}</li>
                                            <li>Mô tả: {!! nl2br(e($nha_cung_cap->Mo_Ta)) !!}</li>
                                        </ul>
                                    </div>
                                    <div class="nk-invoice-head-item text-sm-end">
                                    </div>
                                </div>
                                <div class="nk-invoice-body">
                                    <div class="h4">Chi tiết nhập hàng</div>
                                    <div class="table-responsive mt-3">
                                        <table class="table nk-invoice-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col"><span class="overline-title">STT</span></th>
                                                    <th class="tb-col"><span class="overline-title">Mã nguyên liệu</span></th>
                                                    <th class="tb-col"><span class="overline-title">Tên nguyên liệu</span></th>
                                                    <th class="tb-col"><span class="overline-title">Số lượng</span></th>
                                                    <th class="tb-col"><span class="overline-title">Giá nhập</span></th>
                                                    <th class="tb-col"><span class="overline-title">Ngày nhập</span></th>
                                                    <th class="tb-col tb-col-end"><span class="overline-title">Thành tiền</span></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($chi_tiet_nhap_hang as $key => $chi_tiet)
                                                    <tr>
                                                        <td class="tb tb-col">{{ $key + 1 }}</td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->Ma_Nguyen_Lieu }}</span>
                                                        </td>
                                                        <td class="tb-col">
                                                            <span>{{ $chi_tiet->getHangHoa->Ten_Nguyen_Lieu }}</span>
                                                        </td>
                                                        <td class="tb-col"><span>{{ $chi_tiet->so_luong_goc }}</span></td>
                                                        <td class="tb-col"><span>{{ number_format($chi_tiet->gia_nhap, 0, '', '.') }} VNĐ</span></td>
                                                        <td class="tb-col">
                                                            <span>
                                                                {{ \Carbon\Carbon::createFromFormat('Y-m-d', $chi_tiet->getNhapKho->ngay_nhap)->format('d-m-Y') }}</span>
                                                        </td>
                                                        <td class="tb-col tb-col-end">
                                                            <span>{{ number_format($chi_tiet->so_luong_goc * $chi_tiet->gia_nhap, 0, '', '.') }} VNĐ</span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="tb-col-md" colspan="4"></td>
                                                    <td colspan="">Tổng:</td>
                                                    <td colspan="1"></td>
                                                    <td class="tb-col tb-col-end">{{ number_format($nha_cung_cap->tong, 0, '', ',') }} VNĐ</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                @include('parts.paginate', ['paginator' => $chi_tiet_nhap_hang])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
