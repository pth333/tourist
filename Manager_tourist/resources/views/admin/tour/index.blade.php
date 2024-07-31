@extends('layouts.admin')
@section('title', 'Tour')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
<link rel="stylesheet" href="{{ asset('editImageCss/editImage.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'tour', 'key' => 'Danh sách'])
    <div class="search-field d-none d-md-block">
        <form action="" method="GET" class="d-flex align-items-center h-100">
            <div class="input-group">
                <div class="input-group-prepend bg-transparent">
                    <i class="input-group-text border-0 mdi mdi-magnify"></i>
                </div>
                <input type="text" class="form-control bg-transparent border-0" name="key" placeholder="Tìm Kiếm...">
            </div>
        </form>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col col-md-12">
                    <button type="button" class="add-btn btn-gradient-success btn-sm float-right" data-toggle="modal" data-target="#add-modal" style="float: right;">Thêm</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tour</th>
                        <th>Mô tả</th>
                        <th>Trạng thái</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($tours) > 0)
                    @foreach($tours as $id => $tour )
                    @php
                    $departureDay = \Carbon\Carbon::parse($tour->departure_day);
                    $returnDay = \Carbon\Carbon::parse($tour->return_day);
                    $nightNumber = $departureDay->diffInDays($returnDay) - 1;
                    @endphp
                    <tr>
                        <td>{{$tour->id}}</td>
                        <td>
                            Tên tour: {{$tour->name_tour}} <br> <br>
                            Giá: {{number_format($tour->price)}} đ/người <br> <br>
                            Phương tiện: {{$tour->type_vehical}} <br> <br>
                            Thời gian: {{$departureDay->diffInDays($returnDay)}} ngày {{$nightNumber}} đêm<br> <br>
                            Số lượng người tham gia: {{ $tour->participants}}/{{ $tour->max_participants}} người <br> <br>
                        </td>

                        <td style="max-width: 350px">{{$tour->description}}</td>
                        @if($tour->t_status == 0)
                        <td><label class="badge badge-gradient-danger">Chưa khởi hành</label></td>
                        @elseif($tour->t_status == 1)
                        <td><label class="badge badge-gradient-warning">Đang khởi hành</label></td>
                        @elseif($tour->t_status == 2)
                        <td><label class="badge badge-gradient-success">Kết thúc</label></td>
                        @endif
                        <td>
                            <img class="image" src=" {{$tour->feature_image_path}}" alt="">
                        </td>
                        <td>
                            <button data-url="{{ route('tour.edit',['id' => $tour->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-warning edit">
                                Sửa
                            </button>
                            <button data-url="{{ route('tour.destroy',['id' => $tour->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
                                Xóa
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="12" class="text-center">No Data Found</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-center">
            {{ $tours->appends(request()->all())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('admin.tour.edit')
@include('admin.tour.add')

@endsection
@section('js')
<script src="{{ asset('ajax/tourAjax.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script src="{{ asset('ckeditor/add.js')}}"></script>
@endsection
