@extends('default')
@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Sửa loại nguyên liệu</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('loai-nguyen-lieu.index') }}">Quản lý loại nguyên liệu</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Sửa</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="{{ route('loai-nguyen-lieu.update', $loai_nguyen_lieu->Ma_Loai_Nguyen_Lieu) }}" method="post" enctype="multipart/form-data" id="form-edit">
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
                                                            <div class="col-lg-6">
                                                                <div class="form-group">
                                                                    <label for="Ma_Loai_Nguyen_Lieu" class="form-label">Mã  loại nguyên liệu</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="Ma_Loai_Nguyen_Lieu" name="Ma_Loai_Nguyen_Lieu" value="{{$loai_nguyen_lieu->Ma_Loai_Nguyen_Lieu}}"  placeholder="Mã  loại nguyên liệu"  maxlength="100" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>                                                            
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="Ten_Loai_Nguyen_Lieu" class="form-label">Tên loại nguyên liệu</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Ten_Loai_Nguyen_Lieu" name="Ten_Loai_Nguyen_Lieu" value="{{ $loai_nguyen_lieu->Ten_Loai_Nguyen_Lieu }}" required>
                                                                </div>
                                                                @if ($errors->has('Ten_Loai_Nguyen_Lieu'))
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('Ten_Loai_Nguyen_Lieu') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" id="quill_editor" data-toolbar="minimal"></div>
                                                                    <input type="hidden" name="Mo_Ta" id="Mo_Ta" value="{{ $loai_nguyen_lieu->Mo_Ta }}">
                                                                </div>
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
