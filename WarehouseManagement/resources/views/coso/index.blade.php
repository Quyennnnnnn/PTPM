@extends('default')

@section('content')
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý cơ sở</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý cơ sở</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                
                                    <ul class="d-flex">
                                       
                                        <li><a href="{{ route('co-so.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em><span>Thêm cơ sở</span></a></li>
                                    </ul>
                                
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive" id="coso-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã cơ sở</span></th>
                                        <th class="tb-col"><span class="overline-title">Tên cơ sở</span></th>
                                        <th class="tb-col"><span class="overline-title">Mô tả</span></th>
                                        <th class="tb-col"><span class="overline-title">Trạng thái</span></th>
                                        <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($co_so as $key => $co_so)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col"><span>{{ $co_so->Ma_Co_So }}</span></td>
                                            <td class="tb-col"><span>{{ $co_so->Ten_Co_So }}</span></td>
                                            <td class="tb-col"><span>{!! $co_so->Mo_Ta !!}</span></td> 
                       
                                            <td class="tb-col" >
                                            <span style="min-width:55px; font-size:13px" class="badge text-bg-{{ 
                                                        $co_so->Trang_Thai =='Ngung_Hoat_Dong' ? 'danger' : 'success'}}">{{  $co_so->Trang_Thai =='Ngung_Hoat_Dong' ? 'Ngừng hoạt động' : 'Hoạt động'}} </span>
                                            </td>
                                            <td class="tb-col tb-col-end">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                        <div class="dropdown-content py-1">
                                                            <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                
                                                                    <li><a href="{{ route('co-so.edit', $co_so->Ma_Co_So) }}"><em class="icon ni ni-edit"></em><span>Sửa</span></a></li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#xoacoso{{ $co_so->Ma_Co_So }}"><em class="icon ni ni-trash"></em><span>Xóa</span>
                                                                        </a>
                                                                    </li>
                                                                
                                                                <li><a href="{{ route('co-so.show', $co_so->Ma_Co_So) }}"><em class="icon ni ni-eye"></em><span>Xem chi tiết</span></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                            <div class="modal fade" id="xoacoso{{ $co_so->Ma_Co_So }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scrollableLabel">Bạn chắc chắn muốn xóa?</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Đồng ý nghĩa là bạn muốn xóa toàn bộ dữ liệu liên quan đến cơ sở này!</div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <form method="POST" action="{{ route('co-so.destroy', $co_so->Ma_Co_So) }}" id="delete-form">
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
