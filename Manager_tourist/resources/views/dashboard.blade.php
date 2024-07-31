@extends('layouts.admin')
@section('title', 'Trang chủ')
@section('content')

<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'Chart-js', 'key' => 'Charts'])
    <div class="row">
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Tổng tour <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ $dataAll['tours']}} tour</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Tour đã đặt <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ $dataAll['orders']}} tour</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Tổng số bài viết <i class="mdi mdi-diamond mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ $dataAll['posts']}} bài</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Tổng số người truy cập <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ $dataAll['users']}} người</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Tổng số khách hàng <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ $dataAll['customers']}} người</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Doanh thu hôm nay <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ number_format($dataAll['dailyRevenue'])}} VNĐ</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Doanh thu tháng này <i class="mdi mdi-diamond mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ number_format($dataAll['monthlyRevenue'])}} VNĐ</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Doanh thu năm nay <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    <h4 class="mb-5">{{ number_format($dataAll['yearlyRevenue'])}} VNĐ</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix mb-4">
                        <h4 class="card-title float-left">Thống kê doanh thu tháng theo từng loại hình</h4>
                        <div id="visit-sale-chart-legend" class="rounded-legend legend-horizontal legend-top-right float-right">

                        </div>
                    </div>
                    <canvas id="revenueChart" style="display: block; height: 581px; width: 1162px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thống kê trạng thái tour</h4>
                    <canvas id="roundChart" style="display: block; height: 398px; width: 796px;"></canvas>
                    <div id="traffic-chart-legend" class="rounded-legend legend-vertical legend-bottom-left pt-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const months = <?php echo json_encode($dataAll['months']); ?>;
        const datasets = <?php echo json_encode($dataAll['datasets']); ?>;
        console.log(datasets);
        const revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        // Biểu đồ tròn
        const roundCtx = document.getElementById('roundChart').getContext('2d');
        const statusAll = <?php echo json_encode($statusAll) ?>;
        console.log(statusAll)
        const roundChart = new Chart(roundCtx, {
            type: 'pie',
            data: {
                labels: ['Chưa khởi hành', 'Đang khởi hành', 'Kết thúc'],
                datasets: [{

                    data: statusAll,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            }
        });
        console.log(roundChart.data)
    });
</script>
@endsection
