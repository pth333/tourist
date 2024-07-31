<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css')}}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css')}}">
    <link rel="icon" href="{{ asset('logodulich.jpg')}}" type="image/x-icon" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <!-- @vite(['resources/css/ckeditor.css']) -->
    @yield('css')
</head>

<body>

    <div class="container-scroller">
        @include('partials.header')
        <div class="container-fluid page-body-wrapper">
            @include('partials.sidebar')
            <div class="main-panel">
                @yield('content')
                @include('partials.footer')
            </div>
        </div>
    </div>

    <script src="{{ asset('vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{ asset('jquery/jquery.min.js')}}"></script>
    <!-- endinject -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- inject:js -->
    <script src="{{ asset('js/off-canvas.js')}}"></script>
    <script src="{{ asset('js/hoverable-collapse.js')}}"></script>
    <script src="{{ asset('js/misc.js')}}"></script>
    <!-- endinject -->
    <!-- Hiển thị form popup -->
    <script src="{{ asset('show/showModal.js')}}"></script>
    <script src="{{ asset('ajax/deleteAjax.js')}}"></script>
    <script src="{{ asset('vendor/sweetAlert2/sweetalert.min.js')}}"></script>
    <script src="{{ asset('vendor/toast/jquery.toast.min.js')}}"></script>

    @if(Session('ok'))
    <script>
        $.toast({
            heading: 'Success',
            text: "{{ Session::get('ok')}}",
            icon: 'success',
            position: 'top-right',
            hideAfter: 3000,
            showHideTransition: 'slide',
        })
    </script>
    @endif
    <!-- Hiển thị form lỗi  -->
    @if (count($errors) > 0)
    <script type="text/javascript">
        $(document).ready(function() {
            $('#add-modal').modal('show');
        });
    </script>
    @endif
    @yield('js')
</body>

</html>
