@extends('default')
@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Xuất kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item"><a href="{{ route('xuat-kho.index') }}">Quản lý xuất kho</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Xuất kho</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                    <form action="{{ route('api.xuat-kho.store') }}" method="POST" id="form-create">
                    @csrf
                    @method('post')
                    <div class="row g-gs">
                        <div class="col-xxl-12">
                            <div class="gap gy-4">
                                <div class="gap-col">
                                    <div class="card card-gutter-md">
                                        <div class="card-body">
                                            <div class="row g-gs">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="Ma_Phieu_Xuat" class="form-label">Mã phiếu Xuất</label>
                                                        <div class="form-control-wrap">
                                                            <input style="width:100%" type="text" class="form-control" id="Ma_Phieu_Xuat" value="{{ $Ma_Phieu_Xuat }}" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="Ngay_Xuat" class="form-label">Ngày xuất kho</label>
                                                        <div class="form-control-wrap">
                                                            <input style="width:100%" type="date" class="form-control" name="Ngay_Xuat" value="{{ old('Ngay_Xuat') }}" required>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                            <div class="form-group"> <label for="Ma_Co_So" class="form-label">Cơ sở</label>
                                                                <div class="form-control-wrap">
                                                                    <select class="js-select" data-search="true" data-sort="false" name="Ma_Co_So" id="Ma_Co_So">
                                                                        <option value="">Cơ sở</option>
                                                                        @foreach ($co_so as $cs)
                                                                            <option value="{{ $cs->Ma_Co_So }}">{{ $cs->Ten_Co_So }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                @if ($errors)
                                                                    <span class="text-danger py-1 mt-2">{{ $errors->first('Ma_Co_So') }}</span>
                                                                @endif
                                                            </div>
                                                    </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="Mo_Ta" class="form-label">Chi tiết</label>
                                                        <div class="form-control-wrap">
                                                            <div class="js-quill" id="quill_editor" data-toolbar="minimal" data-placeholder="Viết chi tiết sản phẩm vào đây..."></div>
                                                            <input type="hidden" name="Mo_Ta" id="Mo_Ta">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="gap-col">
                                    <div class="card card-gutter-md">
                                        <table id="item-table" class="table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="tb-col">Mã-tên nguyên liệu</th>
                                                    <th class="tb-col">Số lượng Xuất</th>
                                                    <th class="tb-col">Giá xuất</th>
                                                    <th class="tb-col tb-col-end">Hành động</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tb-container">
                                                <tr class="item-row">
                                                    <td class="tb-col">
                                                        <div class="form-control-wrap d-flex">
                                                            <select name="Ma_Nguyen_Lieu[]" class="form-control" required style="width: 100%;">
                                                                @foreach ($nguyen_lieu as $hang)
                                                                    <option value="{{ $hang->Ma_Nguyen_Lieu }}">{{ $hang->Ten_Nguyen_Lieu }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td class="tb-col">
                                                        <div class="form-control-wrap">
                                                            <input style="width:100%" type="number" class="form-control" name="So_Luong[]" required />
                                                        </div>
                                                    </td>
                                                    <td class="tb-col">
                                                        <div class="form-control-wrap">
                                                            <input style="width:100%" type="number" class="form-control" name="Gia_Xuat[]" required />
                                                        </div>
                                                    </td>
                                                    <td class="tb-col tb-col-end text-center">
                                                        <button type="button" class="btn btn-danger btn-sm remove-item">Xóa</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="button" class="btn btn-primary btn-sm" id="add-item">Thêm</button>
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
                    <input type="hidden" name="Ma_Phieu_Xuat" value="{{ $Ma_Phieu_Xuat }}">
                </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Import Quill.js -->
    <script src="{{ asset('assets/js/libs/editors/quill.js') }}"></script>
    <script>
        const quill = new Quill('#quill_editor', {
            theme: 'snow'
        });
       document.getElementById('form-create').addEventListener('submit', function (e) {
    const Mo_Ta_Input = document.querySelector('input[name="Mo_Ta"]');
    Mo_Ta_Input.value = quill.root.innerHTML; 
});
document.addEventListener('click', function (e) {
    if (e.target && e.target.classList.contains('remove-item')) {
        const row = e.target.closest('.item-row');
        if (row) {
            row.remove();
        }
    }
});
document.getElementById('add-item').addEventListener('click', function () {
    const row = document.querySelector('.item-row').cloneNode(true);
    const inputs = row.querySelectorAll('input');
    inputs.forEach(input => input.value = '');
    document.getElementById('tb-container').appendChild(row);
});


    </script>
@endsection
