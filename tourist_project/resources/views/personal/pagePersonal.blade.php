@extends('layouts.master')
@section('title', 'Thông tin cá nhân')
@section('css')
<link rel="stylesheet" href="{{ asset('person/css/person.css')}}">
@endsection
@section('content')
@include('components.slider.slider')
<div class="container-xxl">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 col-md-3 sidebar">
                <h4>Quản lý tài khoản</h4>
                <a href="{{ route('manager.tour')}}">Quản lý tour cá nhân</a>
                <a href="{{ route('password.change')}}">Đổi mật khẩu</a>
            </div>
            <!-- Form hiển thị thông tin cá nhân -->
            <div class="col-lg-9 col-md-9 form-container">
                <div class="personal-info-form">
                    <div class="form-title">Thông tin cá nhân</div>
                    <form>
                        <div class="mb-3">
                            <label for="fullname" class="form-label">Họ và tên:</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ $userDetail->name}}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $userDetail->email}}" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="0123456789" readonly>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
