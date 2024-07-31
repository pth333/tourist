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
                        <h1 class="mb-5">Đổi Mật Khẩu</h1>
                    </div>
                    <div class="bg-light rounded p-4 p-sm-5 my-4 wow fadeInUp" data-wow-delay="0.2s">
                        <form method="POST" action="{{ route('password.change.post')}}">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Mật Khẩu Hiện Tại</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật Khẩu Mới</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác Nhận Mật Khẩu Mới</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Đổi Mật Khẩu</button>
                        </form>
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
            position: 'top-right',
            hideAfter: 3000,
            showHideTransition: 'slide'
        });
    </script>
    @endif
</body>

</html>
