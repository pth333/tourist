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
                <h6 class="section-title bg-white text-center text-primary px-3">Địa điểm</h6>
                <h1 class="mb-5">Các địa điểm</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-2">
                    <div class="filter-form">
                        <form action="{{ route('filter.destination') }}" method="GET" class="row">
                            <h5 class="filter-header">Bộ lọc tìm kiếm</h5>
                            <div class="col-12 mb-3">
                                <label for="ticket_price" class="form-label">Giá vé</label>
                                <select class="form-control" id="ticket_price" name="ticket_price">
                                    <option value="">Chọn giá vé</option>
                                    @foreach($ticketPrice as $ticketPriceItem)
                                    @if($ticketPriceItem->ticket_price == 'Miễn phí')
                                    <option value="{{ $ticketPriceItem->ticket_price}}">Miễn phí</option>
                                    @else
                                    <option value="{{ $ticketPriceItem->ticket_price}}">{{ $ticketPriceItem->ticket_price}}VNĐ</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="category" class="form-label">Loại hình</label>
                                <select class="form-control" id="category" name="category">
                                    <option value="">Chọn loại hình</option>
                                    @foreach($categoryItems as $category )
                                    <option value="{{ $category->id}}">{{ $category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <button type="submit" class="btn btn-primary w-100">Lọc</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-10">
                    <div class="row g-4 justify-content-center">
                        @foreach($destinationList as $destinationItem)
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12 destination-item wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="{{ route('destination.detail', ['id' => $destinationItem->id, 'slug' => $destinationItem->slug ])}}">
                                <img class="img-fluid" src="{{ $fileImage.$destinationItem['feature_image_path']}}" alt="">
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">{{ $destinationItem->name_des}}</div>
                            </a>
                        </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $destinationList->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Destination Start -->
@endsection
