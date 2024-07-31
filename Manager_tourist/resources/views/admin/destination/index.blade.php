@extends('layouts.admin')
@section('title', 'Địa điểm')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
<link rel="stylesheet" href="{{ asset('editImageCss/editImage.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'địa điểm', 'key' => 'Danh sách'])
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
                        <th>Tên</th>
                        <th>Địa Chỉ</th>
                        <th>Giá vé</th>
                        <th>Mô tả</th>
                        <th>Danh mục</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>

                    @if(count($destinations) > 0)
                    @foreach($destinations as $id => $destination )
                    <tr>
                        <td>{{$destination->id}}</td>
                        <td>{{$destination->name_des}}</td>
                        <td>{{$destination->address}}</td>
                        <td>{{$destination->ticket_price}}</td>
                        <td>{!! $destination->description !!}</td>
                        <!-- <td>{{$destination->latitude}}</td>

                        <td>{{$destination->longtitude}}</td> -->
                        <td>{{ optional($destination->category)->name }}</td>
                        <td>
                            <img class="image" src=" {{$destination->feature_image_path}}" alt="">
                        </td>
                        <td style="text-align: center;">
                            <button data-url="{{ route('destination.edit', ['id' => $destination->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-warning edit">
                                Sửa
                            </button>
                            <button data-url="{{ route('destination.destroy', ['id' => $destination->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
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
            {{ $destinations->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('admin.destination.edit')
@include('admin.destination.add')

@endsection
@section('js')
<script src="{{ asset('ajax/destinationAjax.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script src="{{ asset('ckeditor/add.js')}}"></script>
@endsection
