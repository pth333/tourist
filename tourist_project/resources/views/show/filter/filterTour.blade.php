@extends('layouts.master')
@section('title', 'Danh sách tour')
@section('css')
<link rel="stylesheet" href="{{ asset('tours/css/tourlist.css')}}">
@endsection


@section('content')
@include('components.slider.slider')
<!-- Destination Start -->
<div class="container-xxl py-5 tour">
    <div class="container">
        <div class="row g-3 tour-container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kết quả lọc</h6>
                <h1 class="mb-5">Các gói tour</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($resultFilters as $resultItem)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                    @php
                    $departureDay = \Carbon\Carbon::parse($resultItem->departure_day);
                    $returnDay = \Carbon\Carbon::parse($resultItem->return_day);
                    $nightNumber = $departureDay->diffInDays($returnDay) - 1;
                    $sale_off = ($resultItem->price - $resultItem->sale_price) / $resultItem->price;
                    $sale_percentage = round($sale_off * 100);
                    @endphp
                    <div class="package-item package">
                        <div class="package-img-container">
                            <img class="img-fluid" src="{{ $fileImage.$resultItem->feature_image_path}}" alt="">
                        </div>
                        <div class="d-flex border-bottom">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-map-marker-alt text-primary me-2"></i>Phú Thọ</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-calendar-alt text-primary me-2"></i>{{$departureDay->diffInDays($returnDay)}} ngày {{$nightNumber}} đêm</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>{{ $resultItem->type_vehical}}</small>
                        </div>
                        <div class="p-4">
                            <h5 class="content-tour">{{ $resultItem->name_tour }}</h5>
                            <div class="container-price d-flex justify-content-center align-items-start flex-column">
                                @if ($resultItem->sale_price != 0)
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="content-tour m-0" style="text-decoration: line-through;">{{ number_format($resultItem->price) }}đ/người</h6>
                                    <span class="discount-tag">{{ $sale_percentage }}% OFF</span>
                                </div>
                                <h5 class="content-tour m-0" style="color: #ff4d4d;">{{ number_format($resultItem->sale_price) }}đ/người</h5>
                                @else
                                <h6 class="content-tour m-0">{{ number_format($resultItem->price) }}đ/người</h6>
                                @endif
                            </div>
                            <div class="quantity_cus">
                                <span><i class="fa-solid fa-location-dot"></i> Nơi khởi hành: {{ $resultItem->departure}}</span>
                            </div>
                            <div class="quantity_cus">
                                <span><i class="fa-regular fa-calendar-days"></i> Ngày xuất phát: {{ \Carbon\Carbon::parse($resultItem->departure_day)->format('d-m-Y')}}</span>
                            </div>
                            <div class="quantity_cus">
                                <span><i class="fa-solid fa-star"></i> Số lượng chỗ: {{$resultItem->max_participants}}</span>
                            </div>
                            <div class="quantity_cus">
                                <span><i class="fa-solid fa-star"></i> Số lượng còn: {{$resultItem->max_participants - $resultItem->participants}}</span>
                            </div>
                            <div class="container-tour d-flex justify-content-center mb-2">
                                <a href="{{ route('tour.detail', ['id' => $resultItem->id, 'slug' => $resultItem->slug]) }}" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Đọc thêm</a>
                                <a href="{{ route('booking.form', ['id' => $resultItem->id, 'slug' => $resultItem->slug]) }}" class="btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Đặt tour</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $resultFilters->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Destination Start -->
@endsection
@section('js')
<script>
    $(document).on('click', '.pagination span', function(event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        // console.log(page);
        fetch_data(page);
    });

    function fetch_data(page) {
        $.ajax({
            url: "/tour?page=" + page,
            success: function(data) {
                $('.destination-container').html(data);
            }
        });
    }
</script>
@endsection
