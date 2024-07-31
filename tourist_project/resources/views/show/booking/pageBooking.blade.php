@extends('layouts.master')
@section('title','Đặt Tour')

@section('content')
@include('components.slider.slider')

<div class="container-xxl py-5 tour">
    <div class="container">
        <div class="row g-3 tour-container">
            <!-- Bảng thông tin giá của từng độ tuổi -->
            <div class="col-lg-7" style="background-color: #f5f5f5; padding:30px; border-radius:5px">
                <h3>Thông tin giá</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Độ Tuổi</th>
                            <th>Giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!$tour->price_adult || !$tour->price_child || !$tour->price_infant)
                        <tr>
                            <td>Người lớn (trên 12)</td>
                            <td class="price_adult">{{ number_format($tour->price)}}đ</td>
                        </tr>

                        <tr>
                            <td>Trẻ em (từ 6 đến 12)</td>
                            <td class="price_child">{{ number_format($tour->price)}}đ</td>
                        </tr>

                        <tr>
                            <td>Sơ sinh (dưới 2)</td>
                            <td class="price_infant">{{ number_format($tour->price)}}đ</td>
                        </tr>
                        @else
                        <tr>
                            <td>Người lớn (trên 12)</td>
                            <td class="price_adult">{{ number_format($tour->price_adult)}}đ</td>
                        </tr>

                        <tr>
                            <td>Trẻ em (từ 6 đến 12)</td>
                            <td class="price_child">{{ number_format($tour->price_child)}}đ</td>
                        </tr>

                        <tr>
                            <td>Sơ sinh (dưới 2)</td>
                            <td class="price_infant">{{ number_format($tour->price_infant)}}đ</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <h3>Thanh toán</h3>
                <table class="table">

                    <tbody>
                        <tr>
                            <td>Tổng tiền</td>
                            <td id="total-price" style="color:red"></td>
                        </tr>
                        <tr>
                            <td>Đặt cọc</td>
                            <td id="deposit_price" style="color:red"></td>
                        </tr>
                    </tbody>
                </table>
            </div>


            <!-- Form đặt tour -->
            <div class="col-lg-5" style="background-color: #f5f5f5; padding:30px; border-radius:5px">
                <div class="booking-form">
                    <div id="error-message" class="alert alert-danger d-none"></div> <!-- Thêm phần tử này để hiển thị thông báo lỗi -->
                    <form class="tour-booking" data-url="{{ route('booking.tour',['id' => $tourId])}}">
                        @csrf
                        <input type="hidden" value="{{ $tourId}}" id="tourId" name="tourId">
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên:</label>
                            <input type="text" class="form-control" id="fullname" name="fullname">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="@error('email') is-invalid @enderror form-control" id="email" name="email">
                            @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="tel" class="@error('phone') is-invalid @enderror form-control" id="phone" name="phone">
                            @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="quantity_adult" class="form-label">Người lớn(trên 12 tuổi)</label>
                            <input type="number" class="form-control" id="quantity_adult" name="quantity_adult" min="1">
                        </div>
                        <div class="mb-3">
                            <label for="quantity_child" class="form-label">Trẻ em(từ 6 đến 12) </label>
                            <input type="number" class="form-control" id="quantity_child" name="quantity_child" min="0">
                        </div>
                        <div class="mb-3">
                            <label for="quantity_infant" class="form-label">Sơ sinh(dưới 2 tuổi)</label>
                            <input type="number" class="form-control" id="quantity_infant" name="quantity_infant" min="0">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <button type="submit" value="1" class="booking-tour btn btn-primary w-100">Thanh toán online</button>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" value="2" class="deposit-tour btn btn-primary w-100">Đặt cọc</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('total_price/tour.js')}}"></script>
<script src="{{ asset('vendor/sweetAlert2/sweetalert.min.js')}}"></script>
@endsection
