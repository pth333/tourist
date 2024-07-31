@extends('layouts.master')

@section('title', 'Danh sách tour yêu thích')

@section('css')
<link rel="stylesheet" href="{{ asset('person/css/person.css')}}">
<!-- Include any additional CSS specific to favorite tours -->
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
                    <div class="form-title">Tour yêu thích</div>
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thông tin</th>
                                <th>Trạng thái</th>
                                <th>Hình ảnh</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Lặp qua các tour của người dùng và hiển thị -->
                            @if(count($favorites) > 0)
                            @foreach($favorites as $index => $favorite)
                            <tr>
                                <td>{{ $index+1 }}</td>
                                <td>
                                    {{ ($favorite->tour)->name_tour}} <br>
                                    <span>Điểm xuất phát:</span> {{($favorite->tour)->departure}} <br>
                                    <span>Điểm đón:</span> {{($favorite->tour)->destination}} <br>
                                    <span>Ngày khởi hành:</span> {{($favorite->tour)->departure_day}} <br>
                                    <span>Ngày trở về:</span> {{($favorite->tour)->return_day}} <br>
                                </td>
                                <td>
                                    @if(($favorite->tour)->t_status === 0)
                                    <span class="badge badge-success">Chưa khởi hành</span>
                                    @elseif(($favorite->tour)->t_status === 1)
                                    <span class="badge badge-warning">Đang khởi hành</span>
                                    @elseif(($favorite->tour)->t_status === 2)
                                    <span class="badge badge-warning">Kết thúc</span>
                                    @endif
                                </td>
                                <td>
                                    <img style="width: 113px; height: 100px" src="{{$fileImage.($favorite->tour)->feature_image_path}}" alt="">
                                </td>
                                <td>
                                    @if(($favorite->tour)->t_status === 0)
                                    <a href="{{ route('tour.detail', ['id' => ($favorite->tour)->id, 'slug' => ($favorite->tour)->slug])}}" class="btn btn-success btn-sm">
                                        Đặt tour
                                    </a>
                                    @else
                                    <a data-url="{{ route('favorite.delete', ['tourId' => ($favorite->tour)->id])}}" class="btn btn-danger btn-sm action_delete">
                                        Xóa
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="12" class="text-center">Chưa có tour yêu thích nào</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $favorites->links('pagination::bootstrap-4') }}
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
