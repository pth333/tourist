    <!-- Destination Start -->
    <div class="container-xxl py-5 destination">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Địa điểm</h6>
                <h1 class="mb-5">Điểm đến yêu thích</h1>
            </div>

            <div id="recommended-item-carousel" class="row g-3">
                <div class="col-lg-7 col-md-6">
                    <div class="row g-3">
                        @foreach($destinations as $index => $destination)
                        @if(($index+1) % 4 != 0)
                        <div class="{{ $destination['col'] }} destination-item wow zoomIn" data-wow-delay="0.1s">
                            <a class="position-relative d-block overflow-hidden" href="{{ route('destination.detail', ['id' => $destination['id'], 'slug' => $destination['slug'] ])}}">
                                <img class="img-fluid" src="{{ $fileImage . $destination['feature_image_path'] }}" alt="">
                                <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">{{ $destination['name_des'] }}</div>
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
                @if($lastIdOfPage)
                <div class="col-lg-5 col-md-6 destination-item  wow zoomIn" data-wow-delay="0.7s" style="min-height: 350px;">
                    <a class="position-relative d-block h-100 overflow-hidden" href="{{ route('destination.detail', ['id' => $destination['id'], 'slug' => $destination['slug'] ])}}">
                        <img class="img-fluid position-absolute w-100 h-100" src="{{ $fileImage.$destinations[$lastIdOfPage-5]['feature_image_path']}}" alt="" style="object-fit: cover;">
                        <div class="bg-white text-primary fw-bold position-absolute bottom-0 end-0 m-3 py-1 px-2">{{ $destinations[$lastIdOfPage-5]['name_des']}}</div>
                    </a>
                </div>
                @endif
            </div>
        </div>
        <a href="{{ route('destination.list')}}" class="btn btn-primary rounded-pill py-2 px-4 position-absolute" style="margin-top: 30px; left: 50%; transform: translateX(-50%);">Xem tất cả</a>

    </div>

    <!-- Destination Start -->

    <style>
        .position-relative {
            height: 100%;
        }

        .position-relative a {
            height: 100%;
        }

        .position-relative img {
            object-fit: cover;
            height: 100%;
            width: 100%;
            border-radius: 8px;
        }

        .destination-item .position-relative {
            border-radius: 8px;
        }

        .col-lg-12 {
            height: 275px;
        }
    </style>
