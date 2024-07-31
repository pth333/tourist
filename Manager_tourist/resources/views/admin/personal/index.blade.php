@extends('layouts.admin')
@section('content')


@include('partials.content-header', ['name' => 'Xem', 'key' => 'Profile'])
<div class="container mt-5" style="padding-bottom: 76px;">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4>Thông tin cá nhân</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('personal.update', ['id' => auth()->id()])}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Họ tên</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Tên" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{ auth()->user()->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Mật khẩu mới">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Mật khẩu mới</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Nhập lại khẩu mới">
                        </div>
                        <button href="{{ route('personal.update', ['id' => auth()->id()])}}" type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                        <a href="{{ route('dashboard')}}" class="btn btn-warning">Trở về trang chủ</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
