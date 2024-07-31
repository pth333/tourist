<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css')}}">
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <h4>Đăng nhập</h4>
                            <form action="{{ route('login')}}" method="POST" class="pt-3">
                                @csrf

                                <div class="form-group">
                                    <input type="email" name="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                                </div>
                                <div class="mt-3">
                                    <button class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">SIGN IN</button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" name="remember_me" class="form-check-input"> Keep me signed in </label>
                                    </div>
                                    <a href="{{ route('forget.password.get')}}" class="auth-link text-black">Forgot password?</a>
                                </div>

                                <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="{{ route('register')}}" class="text-primary">Create</a>
                                </div>
                            </form>
                            <!-- <div class="text-center mt-3">
                                <a href="auth/google/redirect" class="btn btn-danger w-100 py-2"><i class="bi bi-google"></i> Đăng nhập với Google</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

    <script src="{{ asset('vendors/js/vendor.bundle.base.js')}}"></script>

    <script src="{{ asset('js/off-canvas.js')}}"></script>
    <script src="{{ asset('js/hoverable-collapse.js')}}"></script>
    <script src="{{ asset('js/misc.js')}}"></script>
    <script src="{{ asset('vendor/toast/jquery.toast.min.js')}}"></script>
    <!-- endinject -->
    @if(Session('ok'))
    <script>
        $.toast({
            heading: 'success',
            text: "{{ Session::get('ok')}}",
            icon: 'success',
            position: 'top-center',
            hideAfter: 3000,
            showHideTransition: 'slide'
        })
    </script>
    @endif
    @if(Session('no'))
    <script>
        $.toast({
            heading: 'warning',
            text: "{{ Session::get('no')}}",
            icon: 'warning',
            position: 'top-center',
            hideAfter: 3000,
            showHideTransition: 'slide'
        })
    </script>
    @endif
</body>

</html>
