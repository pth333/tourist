@extends('layouts.master')
@section('title', 'Chi tiết bài viết')
@section('css')
<link rel="stylesheet" href="{{ asset('post/css/postDetail.css')}}">
<link rel="stylesheet" href="{{ asset('comment/css/comment.css')}}">
@endsection
@section('content')
@include('components.slider.slider')
<div class="container-xxl py-5 blog-detail">
    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h6 class="section-title bg-white text-center text-primary px-3">Chi tiết Bài Viết</h6>
            <h1 class="mb-5">{{ $postDetail->name_post }}</h1>
        </div>
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="wow fadeInUp image" data-wow-delay="0.1s">
                    <img class="img-fluid w-100 mb-4" src="{{ $fileImage.$postDetail->image_post }}" alt="{{ $postDetail->name_post }}" style="border-radius:5px">
                </div>
                <div class="wow fadeInUp container-child" data-wow-delay="0.3s">
                    <h4 class="mb-4">Nội dung</h4>
                    <p class="blog-author text-muted mb-4">
                        <i class="fa fa-user me-2"></i>{{ ($postDetail->user)->name }} |
                        <i class="fa fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($postDetail->created_at)->format('d/m/Y') }}
                    </p>
                    <div class="blog-content">
                        {!! $postDetail->content !!}
                    </div>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="wow fadeInUp" data-wow-delay="0.5s">
                        <h5 class="mb-4" style="border-bottom: 1px solid #ddd; padding-bottom: 10px;">BÀI VIẾT MỚI</h5>
                        <div class="row">
                            @foreach($postNews as $postNew)
                            <div class="col-md-12 mb-3">
                                <a href="{{ route('post.detail', ['id' => $postNew->id, 'slug' => $postNew->slug])}}">
                                    <div class="new-blog-item">
                                        <img class="img-fluid mb-2" src="{{ $fileImage.$postNew->image_post }}" alt="{{ $postNew->name_post }}">
                                        <div class="new-blog-info">
                                            <p class="new-blog-title">{{ $postNew->name_post }}</p>
                                            <p class="new-blog-meta">
                                                <span class="new-blog-author"><i class="fa fa-user me-2"></i>{{ ($postNew->user)->name }}</span>
                                                <span class="new-blog-date"><i class="fa fa-calendar-alt me-2"></i>{{ \Carbon\Carbon::parse($postNew->created_at)->format('d/m/Y') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="comment-form">
                    <h5>Để lại bình luận</h4>
                        <form action="{{ route('comment.post')}}" method="post">
                            @csrf
                            <input type="hidden" value="{{ $postDetail->id}}" name="postId">
                            <div class="mb-3">
                                <label for="comment_fullname" class="form-label">Họ và tên:</label>
                                <input type="text" class="form-control" id="comment_fullname" name="fullname" require>
                            </div>
                            <div class="mb-3">
                                <label for="comment_email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="comment_email" name="email" require>
                            </div>
                            <div class="mb-3">
                                <label for="comment_content" class="form-label">Nội dung:</label>
                                <textarea class="form-control" id="comment_content" name="content" rows="4" require></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                        </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js')
@if(Session::has('ok'))
<script>
    $.toast({
        heading: 'Thành công',
        text: "{{ Session::get('ok') }}",
        icon: 'success',
        position: 'top-right',
        hideAfter: 3000,
        showHideTransition: 'slide'
    });
</script>
@endif
@endsection
