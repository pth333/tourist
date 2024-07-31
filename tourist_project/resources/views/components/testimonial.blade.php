    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Bình Luận</h6>
                <h1 class="mb-5">Phản hồi của khách hàng!!!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
                @foreach($comments as $comment)
                <div class="testimonial-item bg-white text-center border p-4">
                    <img class="bg-white rounded-circle shadow p-1 mx-auto mb-3" src="" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">{{ $comment->fullname}}</h5>
                    <p class="mt-2 mb-0">{{ $comment->content}}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
