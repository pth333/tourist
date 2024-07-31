@extends('layouts.master')
@section('title', 'Chi tiết điểm đến')
@section('css')
<link rel="stylesheet" href="{{ asset('destination/css/list.css')}}">
<link rel="stylesheet" href="{{ asset('tours/css/tourDetail.css')}}">
@endsection

@section('content')
@include('components.slider.slider')
<!-- Destination Detail Start -->
<div class="container-xxl py-5 destination-detail">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Chi tiết Tour</h6>
            <h1 class="mb-5">{{ $tourDetail->name_tour}}</h1>
        </div>
        <div class="container mt-5">
            <div class="row g-5">
                <div class="col-lg-8">
                    <div class="wow fadeInUp image" data-wow-delay="0.1s">
                        <img class="img-fluid w-100 mb-4" src="{{$fileImage.$tourDetail->feature_image_path}}">
                    </div>
                    <div id="tourDetails">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Chi tiết</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="itinerary-tab" data-bs-toggle="tab" data-bs-target="#itinerary" type="button" role="tab" aria-controls="itinerary" aria-selected="false">Lịch trình</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                <div class="wow fadeInUp container-child" data-wow-delay="0.3s">
                                    <h4>Mô tả</h4>
                                    <p>{!! $tourDetail->description !!}</p>
                                </div>
                                <div class="wow fadeInUp container-child" data-wow-delay="0.3s">
                                    <h4 class="mb-4">Ảnh chi tiết</h4>
                                    <div class="row g-3">
                                        @foreach($tourDetail->images as $image)
                                        <div class="col-lg-4 col-md-6">
                                            <div class="image-container">
                                                <img class="img-fluid" src="{{ $fileImage.$image->image_path }}">
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="wow fadeInUp container-child" data-wow-delay="0.3s">
                                    <h4 class="mb-4">Tổng quan</h4>
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th scope="row">Điểm đi</th>
                                                <td>{{ $tourDetail->departure }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Điểm đến</th>
                                                <td>{{ $tourDetail->destination }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ngày Đi</th>
                                                <td>{{ \Carbon\Carbon::parse($tourDetail->departure_day)->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Ngày Về</th>
                                                <td>{{ \Carbon\Carbon::parse($tourDetail->return_day)->format('d/m/Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Phương tiện</th>
                                                <td>{{ $tourDetail->type_vehical }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="itinerary" role="tabpanel" aria-labelledby="itinerary-tab">
                                <!-- Nội dung lịch trình -->
                                <div class="schedule-detail">
                                    <h4>Lịch trình chi tiết</h4>
                                    @foreach($scheduleDetail as $scheduleDetailItem)
                                    <div class="day-itinerary">
                                        <h5 id="day-{{ $loop->index }}">Ngày {{ $scheduleDetailItem->order_date }} - {{ $scheduleDetailItem->schedule }} ({{ $scheduleDetailItem->activity }})</h5>
                                        <div class="excerpt">
                                            <span class="line"></span>
                                            <div>
                                                <p style="text-align:justify"> {!! $scheduleDetailItem->description !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form đặt tour -->
                <div class="col-lg-4">
                    <div class="wow fadeInUp booking-form" style="margin-bottom: 25px" data-wow-delay="0.1s">
                        <div class="book-tour-header" style="display: flex; align-items: center;">
                            <h5 style="margin: 0; margin-right: 10px;">Giá chỉ từ:</h5>
                            @if($tourDetail->sale_price != 0)
                            <div style="display: flex; flex-direction: column; margin-left: 60px;">
                                <h6 style="text-decoration: line-through; color: grey; margin: 0;">{{ number_format($tourDetail->price) }}đ/người</h6>
                                <h5 style="color: red; margin: 0;">{{ number_format($tourDetail->sale_price) }}đ/người</h5>
                            </div>
                            @else
                            <h6 style="margin: 0; margin-left: 20px;">{{ number_format($tourDetail->price) }}đ/người</h6>
                            @endif
                        </div>

                        <div class="booking-tour" style="text-align: center; margin-top: 10px;">
                            <a href="" class="btn btn-primary">Liên hệ</a>
                            <a href="{{ route('booking.form', ['id' => $tourDetail->id, 'slug' => $tourDetail->slug])}}" class="btn btn-primary">Đặt tour</a>
                        </div>
                    </div>
                    <!-- Tour liên quan -->
                    <div class="background-related-tour" style="background-color: #f5f5f5; padding: 15px; border-radius: 5px">
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                            <h5 class="related-tours-header">DANH SÁCH TOUR LIÊN QUAN</h5>
                        </div>
                        @foreach($relatedTours as $tourItem)
                        <div class="wow fadeInUp" data-wow-delay="0.1s">
                            @php
                            $departureDay = \Carbon\Carbon::parse($tourItem->departure_day);
                            $returnDay = \Carbon\Carbon::parse($tourItem->return_day);
                            $nightNumber = $departureDay->diffInDays($returnDay) - 1;
                            $sale_off = ($tourItem->price - $tourItem->sale_price) / $tourItem->price;
                            $sale_percentage = round($sale_off * 100);
                            @endphp
                            <div class="package-item package">
                                <div class="package-img-container">
                                    <img class="img-fluid" src="{{ $fileImage.$tourItem->feature_image_path}}" alt="">
                                </div>
                                <div class="d-flex border-bottom">
                                    <small class="flex-fill text-center border-end py-2"><i class="fa fa-map-marker-alt text-primary me-2"></i>Phú Thọ</small>
                                    <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{$departureDay->diffInDays($returnDay)}} ngày {{$nightNumber}} đêm</small>
                                    <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>{{ $tourItem->type_vehical}}</small>
                                </div>
                                <div class="p-4">
                                    <h5 class="content-tour">{{ $tourItem->name_tour}}</h5>
                                    <div class="container-price d-flex justify-content-center align-items-start flex-column">
                                        @if($tourItem->sale_price !=0)
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="content-tour m-0" style="text-decoration: line-through;">{{ number_format($tourItem->price) }}đ/người</h6>
                                            <span class="discount-tag">{{ $sale_percentage}}% Giảm</span>
                                        </div>
                                        <h5 class="content-tour m-0" style="color: #ff4d4d;">{{ number_format($tourItem->sale_price) }}đ/người</h5>
                                        @else
                                        <h6 class="content-tour m-0">{{ number_format($tourItem->price) }}đ/người</h6>
                                        @endif
                                    </div>
                                    <div class="quantity_cus">
                                        <span><i class="fa-solid fa-location-dot"></i> Nơi khởi hành: {{ $tourItem->departure}}</span>
                                    </div>
                                    <div class="quantity_cus">
                                        <span><i class="fa-regular fa-calendar-days"></i> Ngày xuất phát: {{ \Carbon\Carbon::parse($tourItem->departure_day)->format('d-m-Y')}}</span>
                                    </div>
                                    <div class="quantity_cus">
                                        <span><i class="fa-solid fa-star"></i> Số lượng chỗ: {{$tourItem->max_participants}}</span>
                                    </div>
                                    <div class="quantity_cus">
                                        <span><i class="fa-solid fa-star"></i> Số lượng còn: {{$tourItem->max_participants - $tourItem->participants}}</span>
                                    </div>
                                    <div class="container-tour d-flex justify-content-center mb-2">
                                        <a href="{{ route('tour.detail', ['id' => $tourItem->id, 'slug' => $tourItem->slug]) }}" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Đọc thêm</a>
                                        <a href="" class="btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Đặt tour</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- End -->


            </div>
        </div>
    </div>
</div>
<!-- Destination Detail End -->
<style>
    .related-tours-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .package-item {
        margin-bottom: 10px;
    }
</style>
@endsection
