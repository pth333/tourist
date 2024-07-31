<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('slider.update')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="sliderId" id="sliderId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập tên slider</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nhập tên slider">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ảnh slider</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control-file @error('image_path') is-invalid @enderror" id="image_path" name="image_path" placeholder="Ảnh slider">
                            @error('image_path')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <img id="feature_image_preview" src="" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Nhập nội dung</label>
                        <textarea name="description" class="form-control tinymce_init_selector @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Submit
                        </button>
                    </div>
                </form>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->
