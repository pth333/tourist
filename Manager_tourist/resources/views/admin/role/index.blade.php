@extends('layouts.admin')
@section('title', 'Quản lý vai trò')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
<link rel="stylesheet" href="{{ asset('editImageCss/editImage.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'vai trò', 'key' => 'Danh sách'])
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
                    <a href="{{ route('role.create')}}" class="add-btn btn-gradient-success btn-sm float-right" style="float: right;">Thêm</a>
                </div>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên</th>
                        <th>Note</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>

                    @if(count($roles ) > 0)
                    @foreach($roles as $id => $role )
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->display_name}}</td>
                        <td style="text-align: center;">
                            <a href="{{ route('role.edit', ['id' => $role->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-warning edit">
                                Sửa
                            </a>
                            <button data-url="{{ route('role.destroy', ['id' => $role->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
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
            {{ $roles->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

@endsection

