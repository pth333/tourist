<!-- Add  Modal -->
<div class="modal fade" id="add-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('post.store')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập tên bài viết</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('name_post') is-invalid @enderror" id="name_post" name="name_post" value="{{ old('name_post')}}" placeholder="Nhập tên bài viết">
                            @error('name_post')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image_post" class="col-sm-2 control-label">Ảnh đại diện</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control-file @error('image_post') is-invalid @enderror" id="image_post" name="image_post" value="{{ old('image_post')}}" placeholder="Ảnh bài viết">
                            @error('image_post')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect3">Chọn danh mục</label>
                        <select class="form-control form-control-sm" name="category_id">
                            <option value="0">Chọn danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Tóm tắt bài viết</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="content">Nội dung bài viết</label>
                        <textarea name="content" id="editor" class="form-control @error('content') is-invalid @enderror"  rows="5">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Submit
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<!-- End Add Modal -->


