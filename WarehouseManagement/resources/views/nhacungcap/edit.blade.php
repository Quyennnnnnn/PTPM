@extends('default')
@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Sửa Nhà Cung Cấp</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('nha-cung-cap.index') }}">Nhà cung cấp</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Sửa</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <form action="{{ route('nha-cung-cap.update', $nha_cung_cap->Ma_nha_cung_cap) }}" method="post" enctype="multipart/form-data" id="form-edit">
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
                                                                <label for="Ten_Nha_Cung_Cap" class="form-label">Tên nhà cung cấp</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Ten_Nha_Cung_Cap"name="Ten_Nha_Cung_Cap" value="{{ old('Ten_Nha_Cung_Cap', $nha_cung_cap->Ten_Nha_Cung_Cap) }}" placeholder="Tên nhà cung cấp" required>
                                                                </div>
                                                                @error('Ten_Nha_Cung_Cap')
                                                                    <span class="text-danger py-1 mt-2">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="Ma_Nha_Cung_Cap" class="form-label">Mã nhà cung cấp</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Ma_Nha_Cung_Cap" name="Ma_Nha_Cung_Cap" value="{{ old('Ma_Nha_Cung_Cap', $nha_cung_cap->Ma_nha_cung_cap) }}" placeholder="Mã nhà cung cấp" readonly>
                                                                </div>
                                                                @error('Ma_Nha_Cung_Cap')
                                                                    <span class="text-danger py-1 mt-2">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="SDT" class="form-label">Số điện thoại</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="SDT" name="SDT" value="{{ old('SDT', $nha_cung_cap->SDT) }}" placeholder="Số điện thoại" required>
                                                                </div>
                                                                @error('SDT')
                                                                    <span class="text-danger py-1 mt-2">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label for="Dia_Chi" class="form-label">Địa chỉ</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="Dia_Chi" name="Dia_Chi" value="{{ old('Dia_Chi', $nha_cung_cap->Dia_Chi) }}" placeholder="Địa chỉ" required>
                                                                </div>
                                                                @error('Dia_Chi')
                                                                    <span class="text-danger py-1 mt-2">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="form-group">
                                                                <label class="form-label">Chi tiết</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="js-quill" id="quill_editor" data-toolbar="minimal" data-placeholder="Viết chi tiết nhà cung cấp vào đây..."></div>
                                                                    <input type="hidden" name="Mo_Ta" value="{{ old('Mo_Ta', $nha_cung_cap->Mo_Ta) }}">
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
        const quill = new Quill('#quill_editor', {
            theme: 'snow'
        });

        // Set the content of the Quill editor to the existing description
        let Mo_Ta = document.querySelector('input[name=Mo_Ta]').value;
        quill.setContents(quill.clipboard.convert(Mo_Ta));

        const form = document.querySelector('#form-edit');
        form.onsubmit = function(e) {
            const Mo_Ta = document.querySelector('input[name=Mo_Ta]');
            Mo_Ta.value = JSON.stringify(quill.getContents());

            return true;
        };
    </script>
@endsection
