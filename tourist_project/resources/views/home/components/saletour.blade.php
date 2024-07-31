<!-- Package Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Các gói tour</h6>
            <h1 class="mb-5">Ưu đãi đặc biệt</h1>
        </div>
        <div class="row g-4 justify-content-center">
            @foreach($tours as $tourItem)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                @php
                $departureDay = \Carbon\Carbon::parse($tourItem->departure_day);
                $returnDay = \Carbon\Carbon::parse($tourItem->return_day);
                $nightNumber = $departureDay->diffInDays($returnDay) - 1;
                $sale_off = ($tourItem->price - $tourItem->sale_price) / $tourItem->price;
                $sale_percentage = round($sale_off * 100);
                @endphp
                <div class="package-item position-relative">
                    <a data-url="{{ route('favorite.add', ['tourId' => $tourItem->id])}}" class="heart-icon position-absolute top-0 end-0 p-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Yêu thích">
                        <i class="fa-regular fa-heart"></i>
                    </a>
                    <div class="package-img-container">
                        <img class="img-fluid" src="{{ $fileImage.$tourItem->feature_image_path }}" alt="">
                    </div>
                    <div class="d-flex border-bottom">
                        <small class="flex-fill text-center border-end py-2">
                            <i class="fa fa-map-marker-alt text-primary me-2"></i>Phú Thọ
                        </small>
                        <small class="flex-fill text-center border-end py-2">
                            <i class="fa fa-calendar-alt text-primary me-2"></i>{{$departureDay->diffInDays($returnDay)}} ngày {{$nightNumber}} đêm
                        </small>
                        <small class="flex-fill text-center py-2">
                            <i class="fa fa-user text-primary me-2"></i>{{ $tourItem->type_vehical }}
                        </small>
                    </div>
                    <div class="p-4">
                        <h5 class="content-tour">{{ $tourItem->name_tour }}</h5>
                        <div class="container-price d-flex justify-content-center align-items-start flex-column">
                            @if ($tourItem->sale_price != 0)
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
                            <a href="{{ route('booking.form', ['id' => $tourItem->id, 'slug' => $tourItem->slug]) }}" class="btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;">Đặt tour</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <a href="{{ route('tour.list')}}" class="btn btn-primary rounded-pill py-2 px-4 position-absolute" style="margin-top: 30px; left: 50%; transform: translateX(-50%);">Xem tất cả</a>
</div>
<!-- Package End -->
