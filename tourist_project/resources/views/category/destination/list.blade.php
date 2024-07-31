@extends('layouts.master')
@section('title', 'Danh sách điểm đến')

@section('css')
<link rel="stylesheet" href="{{ asset('destination/css/list.css')}}">
@endsection

@section('content')
@include('components.slider.slider')
<!-- Destination Start -->
<div class="container-xxl py-5 destination">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Loại Hình</h6>
            <h1 class="mb-5">{{ optional($categoryTitleDestination)->name }}</h1>
        </div>
        <div class="row g-3 destination-container">
            @foreach($destinations as $destinationItem)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 destination-item wow zoomIn" data-wow-delay="0.1s">
                <a class="position-relative d-block overflow-hidden" href="{{ route('destination.detail', ['id' => $destinationItem->id, 'slug' => $destinationItem->slug ])}}">
                    <img class="img-fluid" src="{{ $fileImage.$destinationItem['feature_image_path']}}" alt="">
                    <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">{{ $destinationItem->name_des}}</div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center">
            {{ $destinations->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
<!-- Destination Start -->

@endsection
