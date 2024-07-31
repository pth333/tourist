@extends('layouts.master')
@section('title', 'Chi tiết điểm đến')
@section('css')
<link rel="stylesheet" href="{{ asset('destination/css/list.css')}}">
<link rel="stylesheet" href="{{ asset('destination/css/destinationDetail.css')}}">
<style>
    .container-child {
        padding: 20px;
        box-shadow: 3px 5px 35px rgba(86, 68, 169, .1)
    }

    .controls {
        margin-top: 10px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 300px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #target {
        width: 345px;
    }
</style>
@endsection

@section('content')
@include('components.slider.slider')

@php
$latitude = $destinationDetail['latitude'];
$longitude = $destinationDetail['longtitude'];
$destinationName = urlencode($destinationDetail['name']);

// Tạo URL để mở Google Maps với điểm đến đã xác định
$googleMapsUrl = "https://www.google.com/maps/dir/?api=1&destination=$latitude,$longitude&destination_place_id=$destinationName";
@endphp
<div class="container-xxl py-5 destination-detail">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Chi tiết địa điểm</h6>
            <h1 class="mb-5">{{ $destinationDetail->name_des }}</h1>
        </div>
        <div class="row g-5">
            <h5><span style="font-weight: 600;">Lượt quan tâm: </span>{{ $views_count}} người</h5>
            <div class="col-lg-8">
                <div class="wow fadeInUp image" data-wow-delay="0.1s">
                    <img class="img-fluid w-100 mb-4" src="{{ $fileImage.$destinationDetail->feature_image_path}}">
                </div>
                <div class="wow fadeInUp container-child" data-wow-delay="0.3s">
                    <h4 class="mb-4">Mô tả</h4>
                    <p>{!! $destinationDetail->description !!}</p>
                </div>
                <div class="wow fadeInUp container-child" data-wow-delay="0.3s">
                    <h4 class="mb-4">Ảnh chi tiết</h4>
                    <div class="row g-3">
                        @foreach($destinationDetail->images as $image)
                        <div class="col-lg-4 col-md-6">
                            <div class="image-container-des">
                                <img class="img-fluid" src="{{ $fileImage.$image->image_path }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="wow fadeInUp container-child" data-wow-delay="0.5s">
                    <h4 class="mb-4">Tổng quan</h4>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th scope="row">Địa chỉ</th>
                                <td>{{ $destinationDetail->address }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Loại hình du lịch</th>
                                <td>{{ $destinationDetail->category->name }}</td>
                            </tr>
                            @if($destinationDetail->ticket_price != 'Miễn phí')
                            <tr>
                                <th scope="row">Giá vé</th>
                                <td>{{ number_format($destinationDetail->ticket_price) }}đ</td>
                            </tr>
                            @else
                            <tr>
                                <th scope="row">Giá vé</th>
                                <td>Miễn Phí</td>
                            </tr>
                            @endif
                            @if(($destinationDetail->open_time && $destinationDetail->close_time) != null)
                            <tr>
                                <th scope="row">Giờ mở cửa</th>
                                <td>{{ $destinationDetail->open_time }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Giờ đóng cửa</th>
                                <td>{{ $destinationDetail->close_time }}</td>
                            </tr>
                            @else
                            <tr>
                                <th scope="row">Giờ mở cửa</th>
                                <td>Mở cả ngày</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <h5 class="mb-4">ĐỊA ĐIỂM MỚI</h5>
                        <div class="row">
                            @foreach($destinationNew as $destinationNewItem)
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('destination.detail', ['id' => $destinationNewItem->id, 'slug' => $destinationNewItem->slug])}}">
                                    <img class="img-fluid" src="{{ $fileImage.$destinationNewItem->feature_image_path }}" alt="{{ $destinationNewItem->name }}">
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Form hiển thị thời tiết -->
                <div class="sidebar mt-5 wow fadeInUp" data-wow-delay="0.5s">
                    <h5 class="mb-4">Dự báo thời tiết</h5>
                    <div id="weather">
                        <input type="hidden" value="{{$latitude}}" id="latitude">
                        <input type="hidden" value="{{$longitude}}" id="longitude">
                        <form id="weatherForm">
                            <div class="form-group">
                                <label for="city">Chọn Ngày:</label>
                                <input type="date" id="date" class="form-control" placeholder="Chọn ngày" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Xem Thời Tiết</button>
                        </form>
                        <div id="weatherResult" class="mt-4">
                            <!-- Kết quả thời tiết sẽ được hiển thị ở đây -->
                        </div>
                    </div>
                </div>
                <!-- Kết thúc form hiển thị thời tiết -->
            </div>
        </div>
    </div>
</div>
<div class="tcontainer-xxl py-5">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.5s">
            <h1 class="mb-5">Map</h1>
            <input id="pac-input" class="controls" type="text" placeholder="Search Box">
            <div id="map" style="width:100%; height:600px;">
            </div>
            <a href="<?php echo $googleMapsUrl; ?>" target="_blank" class="btn btn-primary mt-3" id="directions-button">Chỉ Đường với Google Maps</a>
        </div>
    </div>
</div>

@endsection
@section('js')

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHKAZxgXCpTbU6ZFIFgv82cFhSy5KvuHU&libraries=places&language=vi&region=VI&callback=initMap"></script>
<script>
    var map, marker, infowindow;
    var markers = [];
    var address_infos = {};
    // Khởi tạo bản đồ Google Maps
    function initMap() {
        // Lấy tọa độ của địa điểm từ cơ sở dữ liệu hoặc bất kỳ nguồn dữ liệu nào khác
        var latitude = <?php echo $destinationDetail['latitude']; ?>;
        var longitude = <?php echo $destinationDetail['longtitude']; ?>;
        // console.log(latitude)
        var myLatLng = {
            lat: parseFloat(latitude),
            lng: parseFloat(longitude)
        };

        // Tạo một đối tượng bản đồ
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15, // Độ phóng to của bản đồ
            center: myLatLng, // Tọa độ trung tâm của bản đồ
            streetViewControl: false,
            mapTypeControl: false
        });

        // Tạo một đánh dấu trên bản đồ
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            title: '<?php echo $destinationDetail['name']; ?>' // Tiêu đề của đánh dấu
        });

        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        // map.addListener('bounds_changed', function() {
        // searchBox.setBounds(map.getBounds());
        // });
    }
</script>
<script src="{{ asset('forecast/forecast_weather.js')}}"></script>
@endsection
