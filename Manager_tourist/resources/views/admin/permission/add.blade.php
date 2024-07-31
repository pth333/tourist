@extends('layouts.admin')
@section('content')
<!-- Add  Modal -->
@include('partials.content-header', ['name' => 'quyền', 'key' => 'Thêm'])
<div class="modal-body">
    <form action="{{ route('permission.store') }}" id="add-blog-form" name="add-blog-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="module_parent">Chọn module quyền</label>
            <select class="form-control form-control-sm" name="module_parent" id="module_parent">
                <option value="0">Chọn danh mục cha</option>
                @foreach(config('permission.table') as $moduleParent)
                <option value="{{ $moduleParent}}">{{$moduleParent }}</option>
                @endforeach
            </select>
        </div>

        <div class="form form-group">
            <div class="col-12">
                <div class="row mb-2">
                    <div class="col-12">
                        <label class="font-weight-bold">
                            <input type="checkbox" class="check_all">
                            Check All
                        </label>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        @foreach(config('permission.module_children') as $moduleChildren)
                        <div class="col-md-3 mb-2">
                            <label>
                                <input type="checkbox" value="{{ $moduleChildren }}" name="module_children[]" class="checkbox_children">
                                {{ $moduleChildren }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save">Submit</button>
            </div>
        </div>
    </form>
</div>

<!-- End Add Modal -->
@endsection
@section('js')
<script src="{{ asset('roles/add/add.js')}}"></script>
@endsection
