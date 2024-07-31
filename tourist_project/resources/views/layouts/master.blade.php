<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('travel/lib/animate/animate.min.css')}} " rel="stylesheet">
    <link href="{{ asset('travel/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{ asset('travel/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css')}}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('travel/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('travel/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('tours/css/tour.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css') }}">
    <link rel="icon" href="{{ asset('yoursmileissuccess.png')}}" type="image/x-icon" />
    <link href="{{ asset('tours/css/tour.css')}}" rel="stylesheet">
    <link href="{{ asset('tours/css/tourlist.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('css')
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->
    <!-- Topbar Start -->
    @include('components.topbar')
    <!-- Topbar End -->
    <!-- Navbar & Hero Start -->
    @include('components.navbar')
    <!-- Navbar End -->
    <!-- Content -->
    @yield('content')
    <!-- End Content -->
    <!-- Testimonial Start -->
    @include('components.testimonial')
    <!-- Testimonial End -->
    <!-- Footer Start -->
    @include('components.footer')
    <!-- Footer End -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    <!-- JavaScript Libraries -->
    <script src="{{ asset('jquery/jquery-3.4.1.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('travel/lib/wow/wow.min.js')}}"></script>
    <script src="{{ asset('travel/lib/easing/easing.min.js')}}"></script>
    <script src="{{ asset('travel/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{ asset('travel/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('travel/lib/tempusdominus/js/moment.min.js')}}"></script>
    <script src="{{ asset('travel/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
    <script src="{{ asset('travel/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <script src="{{ asset('vendor/sweetAlert2/sweetalert.min.js')}}"></script>
    <script src="{{ asset('person/favorite/js/favorite_personal.js')}}"></script>
    <!-- Template Javascript -->
    <script src="{{ asset('travel/js/main.js')}}"></script>
    <script src="{{ asset('vendor/toast/jquery.toast.min.js') }}"></script>
    <script src="https://www.gstatic.com/dialogflow-console/fast/messenger/bootstrap.js?v=1"></script>
    <df-messenger intent="WELCOME" chat-title="TouristBot" agent-id="7e9b17d3-0ae1-4b6c-9043-25e3876c60bc" language-code="vi"></df-messenger>
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
    @yield('js')
</body>

</html>
