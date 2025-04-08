@extends('default')

@section('style')
    <style>
        .w-10 {
            width: 10% !important;
        }
    </style>
@endsection

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
                                        <li class="breadcrumb-item"><a href="{{ route('loai-nguyen-lieu.index') }}">Quản lý loại nguyên liệu</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            {{ $loai_nguyen_lieu->Ten_Loai_Nguyen_Lieu }}
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li><a href="{{ route('loai-nguyen-lieu.edit', $loai_nguyen_lieu->Ma_Loai_Nguyen_Lieu) }}" class="btn btn-primary d-md-inline-flex">
                                        <em class="icon ni ni-edit"></em><span>Sửa loại nguyên liệu</span></a>
                                    </li>
                                    <li style="margin-left: 10px;">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#xoaloainguyenlieu{{ $loai_nguyen_lieu->Ma_Loai_Nguyen_Lieu }}"class="btn btn-danger d-md-inline-flex">
                                        <em class="icon ni ni-trash"></em><span>Xoá loại nguyên liệu</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col card mb-5">
                            <div class="card-body">
                                <h4 class="bio-block-title">Chi tiết</h4>
                                <ul class="list-group list-group-borderless small">
                                    <li class="list-group-item">
                                        <span class="title fw-medium w-12 d-inline-block">Tên loại nguyên liệu:</span>
                                        <span class="text">{{ $loai_nguyen_lieu->Ten_Loai_Nguyen_Lieu }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <span class="title fw-medium w-12 d-inline-block">Mô tả:</span>
                                        <span class="text">{!! $loai_nguyen_lieu->Mo_Ta ?? 'Không có mô tả' !!}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="xoaloainguyenlieu{{ $loai_nguyen_lieu->Ma_Loai_Nguyen_Lieu }}" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="scrollableLabel">Bạn chắc chắn muốn xóa?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">Đồng ý nghĩa là bạn muốn xóa toàn bộ dữ liệu liên quan đến loại nguyên liệu này!</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form method="POST" action="{{ route('loai-nguyen-lieu.destroy', $loai_nguyen_lieu->Ma_Loai_Nguyen_Lieu) }}" id="delete-form">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-primary">Đồng ý</button>
                </form>
            </div>
        </div>
    </div>
</div>
                                      
