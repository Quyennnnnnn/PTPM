<!-- resources/views/co_so/edit.blade.php -->
@extends('default')

@section('content')
<div class="nk-content">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head">
                    <div class="nk-block-head-between flex-wrap gap g-2">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Chỉnh Sửa Cơ Sở</h2>
                            <nav>
                                <ol class="breadcrumb breadcrumb-arrow mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('co-so.index') }}">Quản lý cơ sở</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa cơ sở</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                
                <div class="nk-block">
                    <form action="{{ route('co-so.update', $co_so->Ma_Co_So) }}" method="POST" enctype="multipart/form-data" id="form-edit">
                        @csrf
                        @method('put')
                        <div class="row g-gs">
                            <div class="col-xxl-12">
                                <div class="gap gy-4">
                                    <div class="gap-col">
                                        <div class="card card-gutter-md">
                                            <div class="card-body">
                                                <div class="row g-gs">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="Ma_Co_So" class="form-label">Mã cơ sở</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="Ma_Co_So" name="Ma_Co_So" value="{{ $co_so->Ma_Co_So }}" readonly>
                                                            </div>
                                                            @if ($errors->has('Ma_Co_So'))
                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('Ma_Co_So') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="Ten_Co_So" class="form-label">Tên cơ sở</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="Ten_Co_So" name="Ten_Co_So" value="{{ $co_so->Ten_Co_So }}" required>
                                                            </div>
                                                            @if ($errors->has('Ten_Co_So'))
                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('Ten_Co_So') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label">Chi tiết</label>
                                                            <div class="form-control-wrap">
                                                                <div class="js-quill" id="quill_editor" data-toolbar="minimal"></div>
                                                                <input type="hidden" name="Mo_Ta" id="Mo_Ta" value="{{ $co_so->Mo_Ta }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="Trang_Thai" class="form-label">Trạng Thái:</label>
                                                            <select id="Trang_Thai" name="Trang_Thai" class="form-select" required>
                                                                <option value="Hoat_Dong" {{ $co_so->Trang_Thai == 'Hoat_Dong' ? 'selected' : '' }}>Hoạt Động</option>
                                                                <option value="Ngung_Hoat_Dong" {{ $co_so->Trang_Thai == 'Ngung_Hoat_Dong' ? 'selected' : '' }}>Ngừng Hoạt Động</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    {{-- <div class="card">
                        <div class="card-inner">
                            <form action="{{ route('co-so.update', $co_so->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label for="Ma_Co-So" class="form-label">Mã Cơ Sở:</label>
                                    <input type="text" id="Ma_Co_So" name="Ma_Co_So" class="form-control" value="{{ $co_so->Ma_Co_So }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="Ten_Co_So" class="form-label">Tên Cơ Sở:</label>
                                    <input type="text" id="Ten_Co_So" name="Ten_Co_So" class="form-control" value="{{ $co_so->Ten_Co_So }}" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="Mo_Ta" class="form-label">Mô Tả:</label>
                                    <textarea id="Mo_Ta" name="Mo_Ta" class="form-control">{{ $co_so->Mo_Ta }}</textarea>
                                </div>
                                
                                <div class="form-group">
                                    <label for="Trang_Thai" class="form-label">Trạng Thái:</label>
                                    <select id="Trang_Thai" name="Trang_Thai" class="form-select" required>
                                        <option value="Hoat_Dong" {{ $co_so->Trang_Thai == 'Hoat_Dong' ? 'selected' : '' }}>Hoạt Động</option>
                                        <option value="Ngung_Hoat_Dong" {{ $co_so->Trang_Thai == 'Ngung_Hoat_Dong' ? 'selected' : '' }}>Ngừng Hoạt Động</option>
                                    </select>
                                </div>
                                
                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary">Lưu Thay Đổi</button>
                                    <a href="{{ route('co-so.index') }}" class="btn btn-secondary">Quay lại</a>
                                </div>
                            </form>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script>
        // Khởi tạo Quill với theme 'snow'
        const quill = new Quill('#quill_editor', { theme: 'snow'
        });

        // Thiết lập nội dung ban đầu của Quill từ giá trị của 'mo_ta'
        let Mo_Ta = document.querySelector('input[name=Mo_Ta]').value;
        if (Mo_Ta) {
            quill.setContents(quill.clipboard.convert(Mo_Ta)); // Xử lý HTML thay vì JSON.parse
        }


        // Khi form submit, lưu nội dung Quill vào input ẩn trước khi gửi đi
        const form = document.querySelector('#form-edit');
        form.onsubmit = function(e) {
            const mo_taInput = document.querySelector('input[name=Mo_Ta]');
            mo_taInput.value = quill.root.innerHTML; // Lấy HTML thô từ Quill
            return true;
        };
    </script>
@endsection