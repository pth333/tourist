@extends('layouts.admin')
@section('title', 'Schedule Tour')
@section('css')
<link rel="stylesheet" href="{{ asset('index/list.css')}}">
@endsection
@section('content')
<div class="content-wrapper">
    @include('partials.content-header', ['name' => 'Schedule Tour', 'key' => 'Danh sách'])
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
                        <th>Hành trình</th>
                        <th>Ngày</th>
                        <th>Hoạt động</th>
                        <th>Mô tả</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($tourSchedules) > 0)
                    @foreach($tourSchedules as $tourSchedule)
                    <tr>
                        <td>{{$tourSchedule->id}}</td>
                        <td>{{$tourSchedule->schedule}}</td>
                        <td>{{$tourSchedule->order_date}}</td>
                        <td>{{$tourSchedule->activity}}</td>
                        <td>{!! $tourSchedule->description !!}</td>
                        <td>
                            <button data-url="{{ route('schedule.edit', ['id' => $tourSchedule->id])}}" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-warning edit">
                                Sửa
                            </button>
                            <button data-url="{{ route('schedule.destroy', ['id' => $tourSchedule->id])}}" id="delete-compnay" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-danger action_delete">
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
            {{ $tourSchedules->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>


@include('admin.schedule_tour.edit')
@include('admin.schedule_tour.add')

@endsection
@section('js')
<script src="{{ asset('ajax/scheduleAjax.js')}}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/34.0.0/classic/ckeditor.js"></script>
<script src="{{ asset('ckeditor/add.js')}}"></script>
@endsection
