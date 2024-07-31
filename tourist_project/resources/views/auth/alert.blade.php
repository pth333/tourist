<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Thông báo xác thực email</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f2f5;
            margin: 0;
        }

        .notification-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .notification-title {
            font-size: 24px;
            font-weight: bold;
            color: #343a40;
            margin-bottom: 20px;
        }

        .notification-message {
            font-size: 18px;
            color: #555555;
            margin-bottom: 30px;
        }

        .btn-back-home {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
        }
    </style>
</head>

<body>

    <div class="notification-container">
        <div class="notification-title">Xác thực tài khoản</div>
        <div class="notification-message">Vui lòng kiểm tra email để xác thực tài khoản của bạn.</div>
        <a href="{{ route('home')}}" class="btn btn-primary btn-back-home">Quay lại trang chủ</a>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
