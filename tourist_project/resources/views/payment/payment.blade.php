<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('travel/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{ asset('travel/css/style.css')}}" rel="stylesheet">
    <style>
        .payment-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .payment-form,
        .method-form {
            background-color: #f5f5f5;
            padding: 30px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container-xxl py-5 tour">
        <div class="container">
            <div class="row g-3 tour-container justify-content-center payment-container">
                <!-- Form thông tin thanh toán -->
                <div class="col-lg-5 payment-form">
                    <div class="booking-form">
                        <form action="{{ route('method.payment') }}" method="POST" class="d-grid gap-2">
                            @csrf
                            <h3>Thông tin thanh toán</h3>
                            @if($orderCustomer['customer']['total_deposit'] == 0)
                            <div class="form-group">
                                <label for="amount">Tổng giá tiền:</label>
                                <input type="text" value="{{ number_format($orderCustomer['customer']['total_price'])}}" class="form-control" id="amount" name="amount" readonly>
                            </div>
                            @elseif($orderCustomer['customer']['total_price'] == 0)
                            <div class="form-group">
                                <label for="amount">Tiền đặt cọc:</label>
                                <input type="text" value="{{ number_format($orderCustomer['customer']['total_deposit'])}}" class="form-control" id="amount" name="amount" readonly>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="amount_per">Tổng số người:</label>
                                <input type="number" value="{{ number_format($orderCustomer['customer']['total_person'])}}" class="form-control" id="amount_per" name="amount_per" readonly>
                            </div>
                            <div class="form-group">
                                <label for="payment_method" class="form-label">Phương thức thanh toán:</label>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="vnpay_payment">Thanh toán VNPAY</option>
                                    <option value="momo_payment">Thanh toán MOMO</option>

                                </select>
                            </div>

                            <div class="form-group" id="bank_select_group">
                                <label for="bank" class="form-label">Ngân hàng:</label>
                                <select class="form-control" id="bank" name="bank" required>
                                    <option value="NCB">NCB</option>
                                    <option value="VCB">Vietcombank</option>
                                    <option value="ACB">Asia Commercial Bank</option>
                                    <option value="TPB">TPBank</option>
                                    <option value="VPB">VPBank</option>

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="language" class="form-label">Ngôn ngữ:</label>
                                <select class="form-control" id="language" name="language" required>
                                    <option value="VN">Tiếng Việt</option>
                                    <option value="EN">English</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="payment_content" class="form-label">Nội dung thanh toán:</label>
                                <textarea class="form-control" id="payment_content" name="payment_content" rows="3"></textarea>
                            </div>


                            <button type="submit" class="btn btn-primary">Thanh toán online</button>
                            <form action="javascript:history.back()">
                                <button type="submit" class="btn btn-secondary">Quay lại trang trước</button>
                            </form>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var paymentMethodSelect = document.getElementById('payment_method');
        var bankSelectGroup = document.getElementById('bank_select_group');

        function toggleBankSelect() {
            if (paymentMethodSelect.value === 'momo_payment') {
                bankSelectGroup.classList.add('hidden');
            } else {
                bankSelectGroup.classList.remove('hidden');
            }
        }

        paymentMethodSelect.addEventListener('change', toggleBankSelect);

        // Initialize the state based on the initial value
        toggleBankSelect();
    });
</script>

</html>
