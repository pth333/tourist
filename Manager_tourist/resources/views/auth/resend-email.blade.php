<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Forget Password</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h4>Xác minh Email</h4>
                            <p>Cảm ơn bạn đã đăng kí vào hệ thống của chúng tôi! Trước khi bắt đầu, bạn phải xác minh địa chỉ email bằng cách click vào link chúng tôi vừa gửi cho bạn? Nếu bạn chưa nhận được email, chúng sẵn lòng gửi cho bạn một email khác </p>

                            <form action="{{ route('resend.email')}}" method="POST" class="pt-3">
                                @csrf
                                <input type="hidden" name="userId" value="{{ session('user')}}">
                                @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                    <p>{{ session('status')}}</p>
                                </div>
                                @endif
                                <div class="mt-3">
                                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Xác minh lại</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
</body>

</html>
