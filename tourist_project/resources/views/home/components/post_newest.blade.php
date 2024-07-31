<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-3">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Bài viết</h6>
                <h1 class="mb-5">Bài viết mới nhất</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach($postsNewest as $postList)
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="package-item package">
                        <div class="package-img-container">
                            <img class="img-fluid" src="{{ $fileImage.$postList->image_post }}" alt="{{ $postList->name_post }}">
                        </div>
                        <div class="p-4">
                            <h5 class="content-blog">{{ $postList->name_post }}</h5>
                            <p class="content-summary">{{ \Illuminate\Support\Str::limit($postList->description, 100) }}</p>
                            <p><span style="font-weight: 600;">Tác giả:</span> {{ ($postList->user)->name}}</p>
                            <p><span style="font-weight: 600;">Ngày tạo:</span> {{ \Carbon\Carbon::parse($postList->created_at)->format('d/m/Y') }}</p>
                            <p><span style="font-weight: 600;">Lượt xem:</span> {{ $postList->view_posts}} người</p>
                            <div class="container-blog d-flex justify-content-center mb-2">
                                <a href="{{ route('post.detail', ['id' => $postList->id, 'slug' => $postList->slug])}}" class="btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px;">Đọc thêm</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>
