<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Đăng ký</title>
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
    <link href="{{ asset('travel/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('travel/css/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css') }}">

</head>

<body>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h6 class="section-title bg-white text-center text-primary px-3">Tài Khoản</h6>
                        <h1 class="mb-5">Đăng Ký</h1>
                    </div>
                    <div class="bg-light rounded p-4 p-sm-5 my-4 wow fadeInUp" data-wow-delay="0.2s">
                        <form method="POST" action="{{ route('register.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và Tên</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus>

                                </div>
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Địa chỉ Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>

                                </div>
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật Khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>

                                </div>
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Xác Nhận Mật Khẩu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Đăng Ký</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="auth/google/redirect" class="btn btn-danger w-100 py-2"><i class="bi bi-google"></i> Đăng nhập với Google</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('jquery/jquery-3.4.1.min.js')}}"></script>
    <!-- Toast Plugin -->
    <script src="{{ asset('vendor/toast/jquery.toast.min.js') }}"></script>
    @if(Session::has('no'))
    <script>
        $.toast({
            heading: 'Cảnh báo',
            text: "{{ Session::get('no') }}",
            icon: 'warning',
            position: 'top-center',
            hideAfter: 3000,
            showHideTransition: 'slide'
        });
    </script>
    @endif
</body>

</html>
