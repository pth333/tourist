@extends('layouts.admin')
@section('content')
<!-- Add  Modal -->
@include('partials.content-header', ['name' => 'vai trò', 'key' => 'Thêm'])
<div class="modal-body">
    <form action="{{ route('role.store') }}" id="add-blog-form" name="add-blog-form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Nhập vai trò</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Nhập vai trò">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="display_name" class="col-sm-2 col-form-label">Chú thích vai trò</label>
            <div class="col-sm-10">
                <input type="text" class="form-control @error('display_name') is-invalid @enderror" id="display_name" name="display_name" value="{{ old('display_name') }}" placeholder="Nhập tên chú thích">
                @error('display_name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
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
                @foreach($permissionParent as $permissionParentItem)
                <div class="card border-primary mb-3">
                    <div class="card-header">
                        <label>
                            <input type="checkbox" value="{{ $permissionParentItem->id }}" class="checkbox_wrapper">
                        </label>
                        Module {{ $permissionParentItem->name }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($permissionParentItem->permissionChildrens as $permissionChildrenItem)
                            <div class="col-md-3 mb-2">
                                <label>
                                    <input type="checkbox" value="{{ $permissionChildrenItem->id }}" name="permission_id[]" class="checkbox_children">
                                    {{ $permissionChildrenItem->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endforeach
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
