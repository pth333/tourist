<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Hoàn thành thanh toán</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('travel/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('travel/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('travel/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('travel/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('travel/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toast/jquery.toast.min.css') }}">
    @yield('css')
</head>

<body>
    <div class="container-xxl py-5 tour">
        <div class="container">
            <div class="row g-3 tour-container justify-content-center mt-5">
                <!-- Hiển thị thông tin thanh toán -->
                <div class="col-lg-5" style="background-color: #f5f5f5; padding:30px; border-radius:5px;">
                    <h4 style="color: #228B22; ">Bạn đã thanh toán thành công. Vui lòng kiểm tra email để nhận thông tin chi tiết về chuyến đi</h4>
                    <div class="booking-form">
                        <h5>Thông tin thanh toán đã lưu</h5>
                        <div class="form-group">
                            <label for="p_price">Mã đơn hàng:</label>
                            <input type="text" value="{{ $vnpayData['vnp_TxnRef'] }}" class="form-control" id="p_price" readonly>
                        </div>
                        <div class="form-group">
                            <label for="p_price">Giá tiền:</label>
                            <input type="text" value="{{ number_format($vnpayData['vnp_Amount'] /100)}} VNĐ" class="form-control" id="p_price" readonly>
                        </div>
                        <div class="form-group">
                            <label for="p_code_vnpay">Mã giao dịch VNPay:</label>
                            <input type="text" value="{{ $vnpayData['vnp_TransactionNo'] }}" class="form-control" id="p_code_vnpay" readonly>
                        </div>
                        <div class="form-group">
                            <label for="p_code_bank">Mã ngân hàng:</label>
                            <input type="text" value="{{ $vnpayData['vnp_BankTranNo'] }}" class="form-control" id="p_code_bank" readonly>
                        </div>
                        <div class="form-group">
                            <label for="p_time">Thời gian thanh toán:</label>
                            <input type="text" value="{{ \Carbon\Carbon::createFromFormat('YmdHis', $vnpayData['vnp_PayDate'])->format('d/m/Y H:i:s') }}" class="form-control" id="p_time" readonly>
                        </div>
                        <div class="form-group">
                            <label for="p_note">Ghi chú:</label>
                            <textarea class="form-control" id="p_note" rows="3" readonly>{{ $vnpayData['vnp_OrderInfo'] }}</textarea>
                        </div>
                        <div class="col-md-5 form-group" style="margin-top: 20px">
                            <a href="{{ route('home')}}" class="btn btn-primary">Trở về trang chủ</a>
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
    @if(Session::has('ok'))
    <script>
        $.toast({
            heading: 'Thành công',
            text: "{{ Session::get('ok') }}",
            icon: 'success',
            position: 'top-right',
            hideAfter: 3000,
            showHideTransition: 'slide'
        });
    </script>
    @endif
</body>

</html>
