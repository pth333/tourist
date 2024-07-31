<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden</title>
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            text-align: center;
        }

        .error-code {
            font-size: 10rem;
            font-weight: bold;
        }

        .message {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .description {
            font-size: 1rem;
            color: #777;
            margin-bottom: 2rem;
        }

        .home-button {
            display: inline-block;
            padding: 0.5rem 1rem;
            font-size: 1rem;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 0.25rem;
            text-decoration: none;
        }

        .home-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-code">403</div>
        <div class="message">Bạn không có quyền truy cập</div>
        <div class="description">Xin lỗi, bạn không có quyền truy cập vào trang này.</div>
        <a href="{{ route('dashboard')}}" class="home-button">Quay lại Trang chủ</a>
    </div>
</body>

</html>


