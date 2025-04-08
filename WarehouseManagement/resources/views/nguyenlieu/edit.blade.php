@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Sửa nguyên liệu</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('nguyen-lieu.index') }}">Quản lý kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">{{ $nguyen_lieu ->Ten_Nguyen_Lieu }}</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="{{ route('nguyen-lieu.update', $nguyen_lieu->Ma_Nguyen_Lieu) }}" method="POST" enctype="multipart/form-data" id="form-edit">
                            @csrf
                            @method('put')
                            <div class="row g-gs">
                                <div class="col-xxl-9">
                                    <div class="gap gy-4">
                                        <div class="gap-col">
                                            <div class="card card-gutter-md">
                                                <div class="card-body">
                                                    <div class="row g-gs">
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="Ma_Nguyen_Lieu" class="form-label">Mã nguyên liệu</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Ten_Nguyen_Lieu" name="Ma_Nguyen_Lieu" value="{{ $nguyen_lieu->Ma_Nguyen_Lieu }}" placeholder="Mã nguyên liệu" required maxlength="100">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('Ma_Nguyen_Lieu') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="Ten_Nguyen_Lieu" class="form-label">Tên nguyên liệu</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Ten_Nguyen_Lieu" name="Ten_Nguyen_Lieu" value="{{ $nguyen_lieu->Ten_Nguyen_Lieu }}" placeholder="Tên nguyên liệu" required maxlength="255">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('Ten_Nguyen_Lieu') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="Don_Vi_Tinh" class="form-label">Đơn vị tính</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Don_Vi_Tinh" name="Don_Vi_Tinh"
                                                                        value="{{ $nguyen_lieu->Don_Vi_Tinh }}" placeholder="Đơn vị tính" required maxlength="50">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('Don_Vi_Tinh') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group"><label for="Barcode" class="form-label">Barcode</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Barcode" name="Barcode" value="{{ $nguyen_lieu->Barcode }}" placeholder="Barcode" maxlength="100">
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('Barcode') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group"><label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" name="Mo_Ta" id="quill_editor" value="{!! $nguyen_lieu->Mo_Ta !!}" data-toolbar="minimal" data-placeholder="Viết chi tiết nguyên liệu vào đây...">
                                                                    </div>
                                                                    <input type="hidden" name="Mo_Ta" value="{{ $nguyen_lieu->Mo_Ta }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3">
                                    <div class="card card-gutter-md">
                                        <div class="card-body">
                                            <div class="row g-gs">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="form-label">Loại nguyên liệu</label>
                                                        <div class="form-control-wrap">
                                                            <select class="js-select" name="Ma_Loai_Nguyen_Lieu" data-search="true" data-sort="false">
                                                                <option value="">Loại nguyên liệu</option>
                                                                @foreach ($loai_nguyen_lieu as $loai)
                                                                    <option value="{{ $loai->Ma_Loai_Nguyen_Lieu }}"{{ old('Ma_Loai_Nguyen_Lieu') == $loai->id ? 'selected' : '' }}>{{ $loai->Ten_Loai_Nguyen_Lieu }}</option>
                                                                @endforeach
                                                            </select>
                                                            
                                                        </div>
                                                        @if ($errors)
                                                            <span class="text-danger py-1 mt-2">{{ $errors->first('Ma_Loai_Nguyen_Lieu') }}</span>
                                                        @endif
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gap-col">
                                    <ul class="d-flex align-items-center gap g-3">
                                        <li><button type="submit" class="btn btn-primary">Lưu</button></li>
                                        <li><a href="{{ url()->previous() }}" class="btn border-0">Quay lại</a>
                                        </li>
                                    </ul>
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
        const quill = new Quill('#quill_editor', {
            theme: 'snow'
        });
        let Mo_Ta = document.querySelector('input[name=Mo_Ta]').value;
        quill.setContents(quill.clipboard.convert(Mo_Ta));

        const form = document.querySelector('#form-edit');
        form.onsubmit = function(e) {
            Mo_Ta = document.querySelector('input[name=Mo_Ta]');
            Mo_Ta.value = JSON.stringify(quill.getContents());

            return true;
        };
    </script>
@endsection
