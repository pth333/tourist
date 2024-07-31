@extends('layouts.master')
@section('title', 'Trang chủ')
@section('css')
<style>
    .hero-header {
        background: linear-gradient(rgba(20, 20, 31, .7), rgba(20, 20, 31, .7)),
        url('{{$fileImage.$sliders->image_path }}');
        background-size: cover;
        padding: 5rem 0;
        position: relative;
        object-fit: cover;
    }

    .search-index {
        top: 100%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 900px;
    }

    #departure_tour {
        border-bottom: 1px solid;
    }

    #destination_tour {
        border-bottom: 1px solid;
    }

    #day_tour {
        border-bottom: 1px solid;
    }

    #location_input {
        border-bottom: 1px solid;
        padding: 5px;
    }
    #search-results-location{
        padding: 10px;
    }
    .search-item-location{
        padding: 10px;
    }
</style>
@endsection
@section('content')

<div class="container-fluid bg-primary py-5 mb-5 hero-header position-relative">
    <div class="container py-5">
        <div class="row justify-content-center py-5">
            <div class="col-lg-10 pt-lg-5 mt-lg-5 text-center">
                <h1 class="display-3 text-white mb-3 animated slideInDown">Tận Hưởng Chuyến Du Lịch Cùng Chúng Tôi</h1>
            </div>
            <div class="position-absolute search-index w-100">
                <!-- Tabs Container -->
                <div class="p-4 bg-white rounded shadow mb-3">
                    <ul class="nav nav-tabs" id="searchTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="tour-tab" data-toggle="tab" href="#tour" role="tab" aria-controls="tour" aria-selected="true">Tìm kiếm Tour</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="location-tab" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="false">Tìm kiếm Địa điểm</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="searchTabsContent">
                        <!-- Form Search Container for Tour -->
                        <div class="tab-pane fade show active" id="tour" role="tabpanel" aria-labelledby="tour-tab">
                            <form action="{{ route('search.tour')}}" method="GET" class="row g-2 mt-3">
                                <div class="col-md-3 position-relative">
                                    <div class="input-group">
                                        <input id="departure_tour" class="form-control py-3" data-url="{{ route('search-departure.ajax')}}" type="text" name="departure" placeholder="Điểm đi">
                                    </div>
                                    <div id="search-results" class="position-absolute w-100"></div>
                                </div>
                                <div class="col-md-3 position-relative">
                                    <div class="input-group">
                                        <input id="destination_tour" class="form-control py-3" data-url="{{ route('search-destination.ajax')}}" type="text" name="destination" placeholder="Điểm đến">
                                    </div>
                                    <div id="search-results-destination" class="position-absolute w-100"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <input id="day_tour" class="form-control py-3" type="date" name="date" placeholder="Ngày đi">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 py-3">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                        <!-- End Form Search Container for Tour -->

                        <!-- Form Search Container for Location -->
                        <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
                            <form action="{{ route('search.location')}}" method="GET" class="row g-2 mt-3">
                                <div class="col-md-9 position-relative">
                                    <div class="input-group">
                                        <input id="location_input" class="form-control py-3" data-url="{{ route('search-location.ajax')}}" type="text" name="location" placeholder="Tên địa điểm">
                                    </div>
                                    <div id="search-results-location" class="position-absolute w-100"></div>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary w-100 py-3">Tìm kiếm</button>
                                </div>
                            </form>
                        </div>
                        <!-- End Form Search Container for Location -->
                    </div>
                </div>
                <!-- End Tabs Container -->
            </div>
        </div>
    </div>
</div>
@include('home.components.destination')
@include('home.components.saletour')
@include('home.components.tour_newest')
@include('home.components.post_newest')
@endsection
@section('js')
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="{{ asset('searchAjax/js/search_ajax')}}"></script>
@endsection
