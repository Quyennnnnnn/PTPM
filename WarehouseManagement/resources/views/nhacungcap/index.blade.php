@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý nhà cung cấp</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý nhà cung cấp</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">

                                    <ul class="d-flex">
                                        {{-- <li><a href="{{ route('nha-cung-cap.create') }}" class="btn btn-primary btn-md d-md-none"><em class="icon ni ni-plus"></em><span>Thêm</span></a></li> --}}
                                        <li>
                                            <a href="{{ route('nha-cung-cap.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Thêm nhà cung cấp</span></a>
                                        </li>
                                    </ul>
                      
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive" id="nhacungcap-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã nhà cung cấp</span></th>
                                        <th class="tb-col"><span class="overline-title">Tên nhà cung cấp</span></th>
                                        <th class="tb-col"><span class="overline-title">Địa chỉ</span></th>
                                        <th class="tb-col"><span class="overline-title">Số điện thoại</span></th>
                                        <th class="tb-col"><span class="overline-title">Mô tả</span></th>
                                        <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nha_cung_cap as $key => $nha)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col"><span>{{ $nha->Ma_nha_cung_cap }}</span></td>
                                            <td class="tb-col"><span>{{ $nha->Ten_Nha_Cung_Cap }}</span></td>
                                            <td class="tb-col"><span>{{ $nha->Dia_Chi }}</span></td>
                                            <td class="tb-col"><span>{{ $nha->SDT }}</span></td>
                                            <td class="tb-col"><span>{{ $nha->Mo_Ta ?? 'Không có mô tả' }}</span></td>
                                            <td class="tb-col tb-col-end">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                        <div class="dropdown-content py-1">
                                                            <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                 
                                                                    <li><a href="{{ route('nha-cung-cap.edit', $nha->Ma_nha_cung_cap) }}"><em class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#xoanhacungcap{{ $nha->Ma_nha_cung_cap }}"><em class="icon ni ni-trash"></em><span>Xóa</span></a>
                                                                    </li>
                                                                
                                                                <li><a href="{{ route('nha-cung-cap.show', $nha->Ma_nha_cung_cap) }}"><em class="icon ni ni-eye"></em><span>Xem chi tiết</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                            <div class="modal fade" id="xoanhacungcap{{ $nha->Ma_nha_cung_cap }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scrollableLabel">Bạn chắc chắn muốn xóa?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Đồng ý nghĩa là bạn muốn xóa toàn bộ dữ liệu liên quan đến nhà cung cấp này!</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <form method="POST" action="{{ route('nha-cung-cap.delete', $nha->Ma_nha_cung_cap) }}" id="delete-form">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-primary">Đồng ý</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection
