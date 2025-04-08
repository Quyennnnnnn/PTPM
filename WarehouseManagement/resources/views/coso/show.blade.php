<!-- resources/views/co_so/show.blade.php -->
@extends('default')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Thông Tin Chi Tiết Cơ Sở</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('co-so.index') }}">Quản lý cơ sở</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Thông Tin Chi Tiết</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <div class="nk-block">
                    <div class="card">
                        <div class="card-inner">
                            <h5 class="card-title">Mã Cơ Sở: {{ $co_so->Ma_Co_So }}</h5>
                            <p class="card-text"><strong>Tên Cơ Sở:</strong> {{ $co_so->Ten_Co_So }}</p>
                            <p class="card-text"><strong>Mô Tả:</strong> {{ $co_so->Mo_Ta }}</p>
                            <p class="card-text"><strong>Trạng Thái:</strong> {{ $co_so->Trang_Thai == 'Hoat_Dong' ? 'Hoạt Động' : 'Ngừng Hoạt Động' }}</p>
                            
                            <a href="{{ route('co-so.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
