@extends('layouts.master')
@section('title', 'Danh sách bài viết')

@section('css')
<link rel="stylesheet" href="{{ asset('destination/css/list.css')}}">
@endsection

@section('content')
@include('components.slider.slider')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-3">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Bài viết</h6>
                <h1 class="mb-5">{{ optional($categoryTitlePost)->name }}</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($posts as $postItem)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="package-item package">
                        <div class="package-img-container">
                            <img class="img-fluid" src="{{ $fileImage.$postItem->image_post }}" alt="{{ $postItem->name_post }}">
                        </div>

                        <div class="p-4">
                            <h5 class="content-blog">{{ $postItem->name_post }}</h5>
                            <p class="content-summary">{{ \Illuminate\Support\Str::limit($postItem->description, 100) }}</p>
                            <p><span style="font-weight: 600;">Tác giả: </span>{{ ($postItem->user)->name}}</p>
                            <p><span style="font-weight: 600;">Ngày tạo: </span>{{ \Carbon\Carbon::parse($postItem->created_at)->format('d/m/Y') }}</p>
                            <p><span style="font-weight: 600;">Lượt xem:</span> {{ $postItem->view_posts}} người</p>
                            <div class="container-blog d-flex justify-content-center mb-2">
                                <a href="{{ route('post.detail', ['id' => $postItem->id, 'slug' => $postItem->slug])}}" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px;">Đọc thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="d-flex justify-content-center">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

