@extends('default')

@section('content')

    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý xuất kho</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý xuất kho</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                <ul class="d-flex">
                                    <li>
                                        <a href="{{ route('xuat-kho.create') }}" class="btn btn-primary d-none d-md-inline-flex"><em class="icon ni ni-plus"></em>
                                            <span>Xuất kho</span>
                                        </a>
                                    </li>
                                    <li style="margin-left: 10px">
                                        <a href="#" class="btn btn-primary d-md-inline-flex" data-bs-toggle="modal" data-bs-target="#xuat_excel"><em class="icon ni ni-file-xls"></em><span>Import</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã phiếu xuất</span></th>
                                        <th class="tb-col"><span class="overline-title">Người xuất</span></th>
                                        <th class="tb-col"><span class="overline-title">Cơ sở</span></th>
                                        <th class="tb-col" data-type="date" data-format="DD-MM-YYYY"><span class="overline-title">Ngày xuất</span></th>
                                        <th class="tb-col tb-col-end"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($phieu_xuat as $key => $phieu)
                                        <tr>
                                            <td class="tb-col"><span>{{ $key + 1 }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->Ma_Phieu_Xuat }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->getUser->Name }}</span></td>
                                            <td class="tb-col"><span>{{ $phieu->getCoSo->Ten_Co_So }}</span></td>
                                            <td class="tb-col"><span> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $phieu->Ngay_Xuat)->format('d-m-Y') }}</span></td>
                                            <td class="tb-col tb-col-end">
                                            <a href="{{ route('xuat-kho.show', $phieu->Ma_Phieu_Xuat) }}" class="btn btn-info btn-sm">
                                                <em class="icon ni ni-eye"></em><span>Xem</span>
                                            </a>
                                            @can('user')
                                            <form action="{{ route('phieu-xuat.delete', $phieu->Ma_Phieu_Xuat) }}" method="POST" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                                    <em class="icon ni ni-trash"></em><span>Xóa</span>
                                                </button>
                                            </form>
                                            @endcan
                                        </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="xuat_excel" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-top">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scrollableLabel">Nhập thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('xuat-kho.import') }}" method="POST" enctype="multipart/form-data" id="form-create">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-gs">
                            <div class="col-lg-6">
                                <div class="form-group"><label for="Ma_Phieu_Xuat"  class="form-label">Mã phiếu xuất</label>
                                    <div class="form-control-wrap">
                                        <input type="text" minlength="1" maxlength="255" class="form-control" id="Ma_Phieu_Xuat" value="{{ $Ma_Phieu_Xuat }}"disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group"> <label for="Ngay_Xuat" class="form-label">Ngày xuất</label>
                                    <div class="form-control-wrap"> <input placeholder="yyyy/mm/dd" type="date" class="form-control" name="Ngay_Xuat"value="{{ old('Ngay_Xuat') }}" id="Ngay_Xuat" required> </div>
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
                                    <label class="form-label">Chi tiết</label>
                                    <div class="form-control-wrap">
                                        <div class="js-quill" id="quill_editor" value="{!! old('Mo_Ta') !!}" data-toolbar="minimal" data-placeholder="Viết chi tiết sản phẩm vào đây...">
                                        </div>
                                        <input type="hidden" name="Mo_Ta">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="input-group"><input type="file" class="form-control" name="excel_file" id="file" required></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-sm btn-primary">Đồng ý</button>
                    </div>
                    <input type="hidden" name="Ma_Phieu_Xuat" value="{{ $Ma_Phieu_Xuat }}">
                </form>
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
        const form = document.querySelector('#form-create');
        form.onsubmit = function(e) {
            const Mo_Ta = document.querySelector('input[name=Mo_Ta]');
            Mo_Ta.value = JSON.stringify(quill.getContents());

            return true;
        };
    </script>
@endsection
