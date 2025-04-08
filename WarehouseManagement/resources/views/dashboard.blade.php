@extends('default')

@section('content')
    <div class="nk-content">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="row g-gs">
                        <div class="col-xxl-12">
                            <div class="row g-gs">
                                <div class="col-md-6">
                                    <div class="card h-100 border-info">
                                        <div class="card-header text-white text-bg-info">Trong ngày</div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Tổng nhập nguyên liệu</span>
                                                <span>{{ number_format($tien_nhap_kho, 0, ',', '.') }} VNĐ</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Tổng xuất nguyên liệu</span>
                                                <!-- Tổng tiền xuất kho hôm nay -->
                                                <p class="card-text">{{ number_format($tien_xuat_kho, 0, ',', '.') }} VNĐ</p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100 border-warning">
                                        <div class="card-header text-white text-bg-warning">Thông tin nguyên liệu</div>
                                        <div class="card-body">
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Loại nguyên liệu</span>
                                                <span>{{ $so_luong_loai_nguyen_lieu  }}</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Nguyên liệu</span>
                                                <span>{{ $so_luong_nguyen_lieu ?? 0 }}</span>
                                            </div>
                                            <div class="d-flex align-items-sm-center justify-content-between">
                                                <span class="amount h6">Nguyên liệu hết hàng</span>
                                                <span>{{ $so_luong_het_hang ?? 0 }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6">
                            <div class="card h-100">
                                <div class="row g-0 col-sep col-sep-md">
                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="card-title-group mb-4">
                                                <div class="card-title">
                                                    <h4 class="title">Nhập và xuất nguyên liệu theo tháng</h4>
                                                </div>
                                            </div>
                                            <div>
                                                <canvas id="chart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-6">
                            <div class="card h-100">
                                <div class="card-body flex-grow-0 py-2">
                                    <div class="card-title-group">
                                        <div class="card-title">
                                            <h4 class="title">Top nguyên liệu theo lượng xuất</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-middle mb-0">
                                        <thead class="table-light table-head-sm">
                                            <tr>
                                                <th class="tb-col"><span class="overline-title">Nguyên liệu</span></th>
                                                <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Số lượng xuất</span></th>
                                                <th class="tb-col tb-col-end tb-col-sm"><span class="overline-title">Giá trị xuất</span></th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @foreach ($so_luong_xuat as $luong_xuat)
                                            <tr>
                                                <td class="tb-col">
                                                    <div class="media-group">
                                                        <div class="media-text">
                                                            <a href="{{ route('nguyen-lieu.show', $luong_xuat->Ma_Nguyen_Lieu) }}"
                                                             class="title">{{ $luong_xuat->Ten_Nguyen_Lieu}}</a>
                                                    </div>
                                                </td>
                                                <td class="tb-col tb-col-end tb-col-sm" ><span class="small">{{ $luong_xuat->Tong_Luong_Xuat }}</span></td>
                                                <td class="tb-col tb-col-end tb-col-sm"><span class="small">{{ number_format($luong_xuat->Tong_Tien_Xuat, 0, '', '.') }} VNĐ</span></td>
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
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.ajax({
                url: '{{ route('api.doanh-thu') }}',
                method: 'GET',
                success: function(response) {
                    let ctx = document.getElementById('chart').getContext('2d');
                    let myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: response.labels,
                            datasets: [
                                {
                                    label: 'Tổng nhập nguyên liệu',
                                    data: response.nhap_values,
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    borderWidth: 1
                                },
                                {
                                    label: 'Tổng xuất nguyên liệu',
                                    data: response.xuat_values,
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    borderWidth: 1
                                }
                            ]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                }
            });
        })
    </script>
@endsection
