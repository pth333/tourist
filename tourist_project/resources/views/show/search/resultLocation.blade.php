@extends('layouts.master')
@section('title', 'Danh sách địa điểm')

@section('css')
<style>
    .destination-item .position-relative {
        border-radius: 8px;
    }

    .destination-item {
        position: relative;
        overflow: hidden;
    }

    .destination-item img {
        width: 100%;
        object-fit: cover;
    }

    .img-fluid {
        border-radius: 5px;
        /* height: 200px; */
    }

    .image img {
        height: 500px;
    }
</style>
@endsection

@section('content')
@include('components.slider.slider')
<!-- Destination Start -->
<div class="container-xxl py-5 destination">
    <div class="container">
        <div class="row g-3 destination-container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kết quả tìm kiếm</h6>
                <h1 class="mb-5">{{$resultSearch->name_des}}</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-12">
                    <div class="row g-4 justify-content-center">
                        <div class="col-lg-8 col-md-6 col-sm-6 col-12 destination-item wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="{{ route('destination.detail', ['id' => $resultSearch->id, 'slug' => $resultSearch->slug ])}}">
                                <img class="img-fluid" src="{{ $fileImage.$resultSearch['feature_image_path']}}" alt="">
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">{{ $resultSearch->name_des}}</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Destination Start -->
@endsection
