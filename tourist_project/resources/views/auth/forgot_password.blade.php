<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Đổi mật khẩu</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('travel/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('travel/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css') }}">
</head>

<body>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title bg-white text-center text-primary px-3">Tài Khoản</h6>
                        <h1 class="mb-5">Quên Mật Khẩu</h1>
                    </div>
                    <div class="bg-light rounded p-4 p-sm-5 my-4 wow fadeInUp" data-wow-delay="0.2s">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('forgot.password.post')}}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Địa Chỉ Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Gửi Liên Kết Đặt Lại Mật Khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
