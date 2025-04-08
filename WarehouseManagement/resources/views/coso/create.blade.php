<!-- resources/views/co_so/create.blade.php -->
@extends('default')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Thêm Cơ Sở Mới</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('co-so.index') }}">Quản lý cơ sở</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Thêm Cơ Sở Mới</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="nk-block">
                    <!-- Form thêm cơ sở -->
                    <form action="{{ route('co-so.store') }}" method="POST" enctype="multipart/form-data" id="form-create">
                        @csrf <!-- CSRF Token -->
                        
                        <div class="row g-gs">
                            <div class="col-xxl-12">
                                <div class="gap gy-4">
                                    <div class="gap-col">
                                        <div class="card card-gutter-md">
                                            <div class="card-body">
                                                <div class="row g-gs">
                                                    <!-- Mã cơ sở -->
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="Ma_Co_So" class="form-label">Mã cơ sở</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="Ma_Co_So" name="Ma_Co_So" value="{{ old('Ma_Co_So') }}" placeholder="Mã cơ sở" required>
                                                            </div>
                                                            @if ($errors->has('Ma_Co_So'))
                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('Ma_Co_So') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Tên cơ sở -->
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="Ten_Co_So" class="form-label">Tên cơ sở</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="Ten_Co_So" name="Ten_Co_So" value="{{ old('Ten_Co_So') }}" placeholder="Tên cơ sở" required>
                                                            </div>
                                                            @if ($errors->has('Ten_Co_So'))
                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('Ten_Co_So') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Chi tiết cơ sở -->
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Chi tiết</label>
                                                            <div class="form-control-wrap">
                                                                <div class="js-quill" id="quill_editor" data-toolbar="minimal" data-placeholder="Viết chi tiết cơ sở vào đây..."></div>
                                                                <input type="hidden" name="Mo_Ta" id="Mo_Ta"> <!-- Input ẩn -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Trạng thái -->
                                                    <div class="form-group">
                                                        <label for="Trang_Thai" class="form-label">Trạng Thái:</label>
                                                        <select id="Trang_Thai" name="Trang_Thai" class="form-select" required>
                                                            <option value="Hoat_Dong" {{ old('Trang_Thai') == 'Hoat_Dong' ? 'selected' : '' }}>Hoạt Động</option>
                                                            <option value="Ngung_Hoat_Dong" {{ old('Trang_Thai') == 'Ngung_Hoat_Dong' ? 'selected' : '' }}>Ngừng Hoạt Động</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nút hành động -->
                                    <div class="gap-col">
                                        <ul class="d-flex align-items-center gap g-3">
                                            <li><button type="submit" class="btn btn-primary">Lưu</button></li>
                                            <li><a href="{{ url()->previous() }}" class="btn border-0">Quay lại</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script>
        const quill = new Quill('#quill_editor', { theme: 'snow' });

        // Lấy dữ liệu HTML từ Quill và gán vào input ẩn trước khi submit
        const form = document.querySelector('#form-create');
        form.onsubmit = function () {
            const moTaInput = document.querySelector('input[name="Mo_Ta"]');
            moTaInput.value = quill.root.innerHTML.trim(); // Lấy dữ liệu HTML từ Quill
        };
    </script>
@endsection
