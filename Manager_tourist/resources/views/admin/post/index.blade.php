@extends('layouts.admin')
@section('title', 'Bài viết')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
<link rel="stylesheet" href="{{ asset('editImageCss/editImage.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'bài viết', 'key' => 'Danh sách'])
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
                        <th>Tên bài viết</th>
                        <th>Tóm tắt</th>
                        <th>Nội dung</th>
                        <th>Hình ảnh</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>

                    @if(count($posts) > 0)
                    @foreach($posts as $id => $post )
                    <tr>
                        <td>{{$post->id}}</td>
                        <td>{{$post->name_post}}</td>
                        <td>{{$post->description}}</td>
                        <td>{!! $post->content !!}</td>
                        <td>
                            <img class="image" src=" {{$post->image_post}}" alt="">
                        </td>
                        <td style="text-align: center;">
                            <button data-url="{{ route('post.edit', ['id' => $post->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-warning edit">
                                Sửa
                            </button>
                            <button data-url="{{ route('post.delete', ['id' => $post->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
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
            {{ $posts->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('admin.post.edit')
@include('admin.post.add')

@endsection
@section('js')
<script src="{{ asset('ajax/postAjax.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script src="{{ asset('ckeditor/add.js')}}"></script>
@endsection
