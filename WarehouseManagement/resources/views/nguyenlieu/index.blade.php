@extends('default')

@section('style')
@endsection

@section('content')
    <div class="nk-content">
        <div class="container">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head">
                        <div class="nk-block-head-between flex-wrap gap g-2">
                            <div class="nk-block-head-content">
                                <h2 class="nk-block-title">Quản lý nguyên liệu</h2>
                                <nav>
                                    <ol class="breadcrumb breadcrumb-arrow mb-0">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Trang chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản lý nguyên liệu</li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="nk-block-head-content">
                                    <ul class="d-flex">
                                        <li>
                                            <a href="{{ route('nguyen-lieu.create') }}" class="btn btn-primary d-md-inline-flex">
                                                <em class="icon ni ni-plus"></em>
                                                <span>Thêm nguyên liệu</span>
                                            </a>
                                        </li>
                                    </ul>
                            </div>
                        </div>
                    </div>
                    <div class="nk-block">
                        <div class="card">
                            <table class="datatable-init table" data-nk-container="table-responsive" id="nguyen-lieu">
                                <thead class="table-light">
                                    <tr>
                                        <th class="tb-col"><span class="overline-title">STT</span></th>
                                        <th class="tb-col"><span class="overline-title">Mã nguyên liệu</span></th>
                                        <th class="tb-col"><span class="overline-title">Tên nguyên liệu</span></th>
                                        <th class="tb-col"><span class="overline-title">Số lượng tồn</span></th>
                                        <th class="tb-col"><span class="overline-title">Đơn vị</span></th>
                                        <th class="tb-col"><span class="overline-title">Loại nguyên liệu</span></th>
                                        <th class="tb-col tb-col-end" data-sortable="false"><span class="overline-title">Hành động</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nguyen_lieu as $key => $hang)
                                        <tr>
                                            <td class="tb-col">
                                                <span>{{ $key + 1 }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span>{{ strlen($hang->Ma_Nguyen_Lieu) > 10 ? substr($hang->Ma_Nguyen_Lieu, 0, 10) . '...' : substr($hang->Ma_Nguyen_Lieu, 0, 10) }}</span>
                                            </td>
                                            <td class="tb-col">
                                                <span>{{ $hang->Ten_Nguyen_Lieu }}</span></td> 
                                            </td>
                                            <td class="tb-col" >
                                            <span style="min-width:55px; font-size:13px" class="badge text-bg-{{ 
                                                        $hang->So_Luong_Ton < 10 ? 'danger' : ($hang->So_Luong_Ton <= 50 ? 'warning' : 'success')}}">{{ $hang->So_Luong_Ton}} </span>
                                            </td>
                                            <td class="tb-col"><span>{{ $hang->Don_Vi_Tinh }}</span></td>
                                            <td class="tb-col">
                                                <span>{{ $hang->loaiNguyenLieu->Ten_Loai_Nguyen_Lieu }}</span> 
                                                <span>{{ $hang->Ma_Loai_Nguyen_Lieu }}</span></td> 
                                            </td>
                                           
                                            
                                            <td class="tb-col tb-col-end">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-sm btn-icon btn-zoom me-n1" data-bs-toggle="dropdown"><em class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-end">
                                                        <div class="dropdown-content py-1">
                                                            <ul class="link-list link-list-hover-bg-primary link-list-md">
                                                                
                                                                    <li>
                                                                        <a href="{{ route('nguyen-lieu.edit', $hang->Ma_Nguyen_Lieu) }}"><em class="icon ni ni-edit"></em><span>Sửa</span></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" data-bs-toggle="modal" data-bs-target="#xoanguyenlieu{{ $hang->Ma_Nguyen_Lieu }}"><em class="icon ni ni-trash"></em><span>Xóa</span></a>
                                                                    </li>
                                                                
                                                                <li>
                                                                    <a href="{{ route('nguyen-lieu.show', $hang->Ma_Nguyen_Lieu) }}"><em class="icon ni ni-eye"></em><span>Xem chi tiết</span></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                            <div class="modal fade" id="xoanguyenlieu{{ $hang->Ma_Nguyen_Lieu }}" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="scrollableLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="scrollableLabel">Bạn chắc chắc muốn xóa?
                                                            </h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">Đồng ý nghĩa là bạn muốn xóa toàn bộ dữ liệu liên quan đến nguyen lieu này!
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <form method="POST" action="{{ route('nguyen-lieu.delete', $hang->Ma_Nguyen_Lieu) }}" id="delete-form">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-sm btn-primary">Đồng
                                                                    ý</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('input[name="excel_file"]').change(function() {
                $('#form-import').submit();
            });

            $('#form-import').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('api.them-nguyen-lieu.import') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.type === 'success') {
                            Swal.fire({
                                title: 'Thành công!',
                                text: response.message,
                                icon: 'success',
                            });
                            setTimeout(() => {
                                window.location.href = response.redirect;
                            }, 2000);
                        } else {
                            Swal.fire({
                                title: 'Thất bại!',
                                text: response.message,
                                icon: 'error'
                            });
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        var errorText = '';

                        $.each(errors, function(index, error) {
                            $.each(error, function(key, value) {
                                errorText += value + "\n";
                            })
                        })

                        alert(errorText);
                    }
                })

            })
        })
    </script>
@endsection
