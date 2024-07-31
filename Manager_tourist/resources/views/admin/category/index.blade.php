@extends('layouts.admin')
@section('title', 'Danh mục')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
@endsection

@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'danh mục', 'key' => 'Danh sách'])
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
                        <th>Tên danh mục</th>
                        <th>Parent_id</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>

                    @if(count($categories) > 0)
                    @foreach($categories as $id => $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->parent_id}}</td>
                        <td style="text-align:center;">
                            <button data-url="{{ route('categories.edit',['id' => $category->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-warning edit">
                                Sửa
                            </button>
                            <button data-url="{{ route('categories.destroy',['id' => $category->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
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
            {{ $categories->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@include('admin.category.edit')
@include('admin.category.add')

@endsection
@section('js')
<script src="{{ asset('ajax/categoryAjax.js')}}"></script>
@endsection
