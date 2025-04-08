@extends('default')

@section('style')
    <style>
        .w-10 {
            width: 10%;
        }
    </style>
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head">
                            <div class="nk-block-head-between flex-wrap gap g-2 align-items-start">
                                <div class="nk-block-head-content">
                                    <div class="d-flex flex-column flex-md-row align-items-md-center">
                                        <div class="media media-huge media-circle"><img src="{{ asset('assets/images/' . auth()->user()->image) }}"
                                                class="img-thumbnail" alt="">
                                        </div>
                                        <div class="mt-3 mt-md-0 ms-md-3">
                                            <h3 class="title mb-1">{{ auth()->user()->Name }}</h3><span
                                                class="small">{{ auth()->user()->Role == 'Admin' ? 'Admin' : 'Nhân viên' }}</span>
                                            <ul class="nk-list-option pt-1">
                                                {{-- <li><em class="icon ni ni-map-pin"></em><span class="small">California, United States</span></li>
                                                    <li><em class="icon ni ni-building"></em><span class="small">Softnio</span></li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-block-head-content">
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#show-profile" type="button">Thông tin</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-profile" type="button">Sửa thông tin</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#edit-password" type="button">Đổi mật khẩu</button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="show-profile">
                            <div class="nk-block">
                                <div class="card card-gutter-md">
                                    <div class="card-body">
                                        <div class="bio-block">
                                            <h4 class="bio-block-title">Thông tin</h4>
                                            <ul class="list-group list-group-borderless small">
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Họ và tên:</span><span
                                                        class="text">{{ auth()->user()->Name }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Giới tính:</span><span
                                                        class="text">{{ auth()->user()->Gioi_Tinh }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Email:</span><span
                                                        class="text">{{ auth()->user()->Email }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Số điện thoại:</span><span
                                                        class="text">{{ auth()->user()->SDT }}</span></li>
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Địa chỉ:</span><span
                                                        class="text">{{ auth()->user()->Dia_Chi }}</span></li>
                                                        
                                                <li class="list-group-item"><span class="title fw-medium w-10 d-inline-block">Ngày đăng ký:</span><span
                                                        class="text">{{ auth()->user()->created_at->format('d-m-Y') }}</span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="edit-profile">
                            <div class="nk-block">
                                <form action="{{ route('user.updateProfile') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    <div class="row g-gs">
                                        <div class="col-xxl-9">
                                            <div class="gap gy-4">
                                                <div class="gap-col">
                                                    <div class="card card-gutter-md">
                                                        <div class="card-body">
                                                            <div class="bio-block">
                                                                <h4 class="bio-block-title mb-4">Sửa thông tin cá nhân</h4>
                                                                <div class="row g-3">
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="name" class="form-label">Họ và tên</label>
                                                                            <div class="form-control-wrap">
                                                                                <input type="text" class="form-control" id="name" placeholder="Họ tên"
                                                                                    name="name" value="{{ auth()->user()->Name }}">
                                                                            </div>
                                                                            @if ($errors)
                                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('name') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Giới tính</label>
                                                                            <div class="form-control-wrap">
                                                                                <select class="js-select" name="gioi_tinh" data-search="false" data-sort="false">
                                                                                    <option value="Nam" {{ old('gioi_tinh') == 'Nam' ? 'selected' : '' }}>Nam
                                                                                    </option>
                                                                                    <option value="Nữ" {{ old('gioi_tinh') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                                                                    <option value="Ẩn" {{ old('gioi_tinh') == 'Ẩn' ? 'selected' : '' }}>Ẩn</option>
                                                                                </select>
                                                                            </div>
                                                                            @if ($errors)
                                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('Gioi_Tinh') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group">
                                                                            <label for="sdt" class="form-label">Số điện thoại</label>
                                                                            <div class="form-control-wrap"><input type="text" class="form-control" id="sdt"
                                                                                    name="sdt" placeholder="Số điện thoại" value="{{ auth()->user()->SDT }}">
                                                                            </div>
                                                                            @if ($errors)
                                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('sdt') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-lg-12">
                                                                        <div class="form-group"><label for="dia_chi" class="form-label">Địa chỉ</label>
                                                                            <div class="form-control-wrap">
                                                                                <input type="text" class="form-control" id="dia_chi" name="dia_chi"
                                                                                    placeholder="Địa chỉ" value="{{ auth()->user()->Dia_Chi }}">
                                                                            </div>
                                                                            @if ($errors)
                                                                                <span class="text-danger py-1 mt-2">{{ $errors->first('Dia_Chi') }}</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-12"><button class="btn btn-primary" type="submit">Xác nhận</button></div>
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
                                                            <div class="form-group"><label class="form-label">Avatar</label>
                                                                <div class="form-control-wrap">
                                                                    <div class="image-upload-wrap d-flex flex-column align-items-center">
                                                                        <div class="media media-huge border">
                                                                            <img id="img" class="w-100 h-100" src="{{ asset('assets/images/' . auth()->user()->image) }}" alt="img">
                                                                        </div>
                                                                        <div class="pt-3">
                                                                            <input class="upload-image" data-target="img" id="change-img" name="change_img"
                                                                                type="file" max="1" hidden>
                                                                            <input type="hidden" id="default-img" name=""
                                                                                value="{{ auth()->user()->image }}">
                                                                            <label for="change-img" class="btn btn-md btn-primary">Thay đổi</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('change_img') }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="edit-password">
                            <div class="nk-block">
                                <div class="card card-gutter-md">
                                    <div class="card-body">
                                        <div class="bio-block">
                                            <div class="card-body">
                                                <form method="POST" action="{{ route('user.updatePassword') }}">
                                                    @csrf
                                                    <div class="row mb-3">
                                                        <label for="old_password" class="col-md-4 col-form-label text-md-end">Mậu khẩu cũ</label>
                                                        <div class="col-md-6">
                                                            <input id="old_password" type="password" class="form-control @error('old_password') is-invalid @enderror"
                                                                name="old_password" required autocomplete="current-password">
                                                            @error('old_password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="password" class="col-md-4 col-form-label text-md-end">Mật khẩu mới</label>
                                                        <div class="col-md-6">
                                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                                                name="password" required autocomplete="new-password">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Nhập lại mật khẩu</label>
                                                        <div class="col-md-6">
                                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                                                                autocomplete="new-password">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-0">
                                                        <div class="col-md-6 offset-md-4">
                                                            <button type="submit" class="btn btn-primary">
                                                                Xác nhận
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

