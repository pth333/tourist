@extends('layouts.master')
@section('title','Quản lý tour cá nhân')
@section('css')
<link rel="stylesheet" href="{{ asset('person/css/person.css')}}">
@endsection
@section('content')
@include('components.slider.slider')
<div class="container-xxl">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-3 sidebar">
                <h4>Quản lý tài khoản</h4>
                <a href="{{ route('manager.tour')}}">Quản lý tour cá nhân</a>
                <a href="{{ route('favorite.tour')}}">Tour yêu thích</a>
                <a href="{{ route('password.change')}}">Đổi mật khẩu</a>
            </div>
            <!-- Form hiển thị thông tin cá nhân -->
            <div class="col-lg-9 col-md-9 form-container">
                <!-- Bảng hiển thị dữ liệu -->
                <div class="tour-management-table mt-5">
                    <div class="form-title">Bảng thông tin chi tiết</div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên tour</th>
                                <th>Thông tin</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Lặp qua các tour của người dùng và hiển thị -->
                            @if(count($orders) > 0)
                            @foreach($orders as $index => $order)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>
                                    {{ ($order->tour)->name_tour}} <br>
                                    <span>Điểm xuất phát:</span> {{($order->tour)->departure}} <br>
                                    <span>Điểm đón:</span> {{($order->tour)->destination}} <br>
                                    <span>Ngày khởi hành:</span> {{($order->tour)->departure_day}} <br>
                                    <span>Ngày trở về:</span> {{($order->tour)->return_day}} <br>
                                </td>
                                <td>
                                    <span>Số người lớn:</span> {{ $order->total_adult}} người - <span>Thành tiền:</span> {{number_format(($order->tour)->price_adult * $order->total_adult)}} VND <br>
                                    <span>Số trẻ em (6-12 tuổi):</span> {{ $order->total_child}} người - <span>Thành tiền:</span> {{number_format(($order->tour)->price_child * $order->total_child)}} VND <br>
                                    <span>Số trẻ em (dưới 6 tuổi):</span> {{ $order->total_infant}} người - <span>Thành tiền:</span> {{number_format(($order->tour)->price_infant * $order->total_infant)}} VND <br>
                                </td>
                                <td>
                                    @if($order->total_price > $order->total_deposit)
                                    <span class="badge badge-success">Đã thanh toán</span>
                                    @else
                                    <span class="badge badge-warning">Chưa hoàn tất</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->total_price < $order->total_deposit)
                                        <a href="{{ route('payment.view', ['orderId' => $order->id])}}" class="btn btn-success btn-sm">
                                            Thanh toán
                                        </a>
                                        @else
                                        <a data-url="{{ route('delete.tour', ['orderId' => $order->id])}}" class="delete btn btn-danger btn-sm action_delete">
                                            Xóa
                                        </a>
                                        @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="12" class="text-center">Chưa đặt tour nào</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $orders->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('vendor/sweetAlert2/sweetalert.min.js')}}"></script>
<script src="{{ asset('tours/js/deletetour.js')}}"></script>
@endsection
