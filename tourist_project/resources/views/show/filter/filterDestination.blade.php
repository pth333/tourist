@extends('layouts.master')
@section('title', 'Danh sách địa điểm')

@section('css')
<link rel="stylesheet" href="{{asset('destination/css/list.css')}}">
@endsection

@section('content')
@include('components.slider.slider')
<!-- Destination Start -->
<div class="container-xxl py-5 destination">
    <div class="container">
        <div class="row g-3 destination-container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Kết quả lọc</h6>
                <h1 class="mb-5">Các địa điểm</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-12">
                    <div class="row g-4 justify-content-center">
                        @foreach($resultFilters as $resultFilterItem)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 destination-item wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="{{ route('destination.detail', ['id' => $resultFilterItem->id, 'slug' => $resultFilterItem->slug ])}}">
                                <img class="img-fluid" src="{{ $fileImage.$resultFilterItem['feature_image_path']}}" alt="">
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">{{ $resultFilterItem->name_des}}</div>
                            </a>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $resultFilters->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Destination Start -->
@endsection
