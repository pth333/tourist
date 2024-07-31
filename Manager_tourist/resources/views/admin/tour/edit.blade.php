<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('tour.update')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="tourId" id="tourId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập tên tour</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name_tour" name="name_tour" placeholder="Nhập Tour">
                            @error('name_tour')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Nhập giá</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Nhập giá">
                                    @error('price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Nhập giá giảm</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('sale_price') is-invalid @enderror" id="sale_price" name="sale_price" placeholder="Nhập giá giảm">
                                    @error('sale_price')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Người lớn</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('price_adult') is-invalid @enderror" id="price_adult" name="price_adult" placeholder="Nhập giá người lớn">
                                    @error('price_adult')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Trẻ em</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('price_child') is-invalid @enderror" id="price_child" name="price_child" placeholder="Nhập giá trẻ em">
                                    @error('price_child')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Sơ sinh </label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('price_infant') is-invalid @enderror" id="price_infant" name="price_infant" placeholder="Nhập giá trẻ sơ sinh">
                                    @error('price_infant')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Ngày khởi hành</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control @error('departure_day') is-invalid @enderror" id="departure_day" name="departure_day" placeholder="Nhập ngày khởi hành">
                                    @error('departure_day')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Ngày trở về</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control @error('return_day') is-invalid @enderror" id="return_day" name="return_day" placeholder="Nhập giờ trở lại">
                                    @error('return_day')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Điểm đi</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('departure') is-invalid @enderror" id="departure" name="departure" placeholder="Nhập điểm đi">
                                    @error('departure')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Điểm đến</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('destination') is-invalid @enderror" id="destination" name="destination" placeholder="Nhập điểm đến">
                                    @error('destination')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="max_participants" class="col-sm-2 control-label">Số người tối đa</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('max_participants') is-invalid @enderror" id="max_participants" name="max_participants" value="{{ old('max_participants')}}" placeholder="Nhập số người tối đa">
                            @error('max_participants')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Loại phương tiện</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('type_vehical') is-invalid @enderror" id="type_vehical" name="type_vehical" placeholder="Nhập loại phương tiện">
                            @error('type_vehical')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ảnh đại diện</label>
                        <div class="col-sm-12">
                            <input type="file" class="form-control-file @error('feature_image_path') is-invalid @enderror" id="feature_image_path" name="feature_image_path" placeholder="Ảnh đại diện">
                            @error('feature_image_path')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <img id="feature_image_preview" src="" alt="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Ảnh chi tiết</label>
                        <div class="col-sm-12">
                            <input type="file" multiple class="form-control-file @error('image_path') is-invalid @enderror" id="image_path" name="image_path[]" placeholder="Ảnh chi tiết">
                            @error('image_path')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <div id="other_images_container"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect3">Chọn danh mục</label>
                        <select class="form-control form-control-sm" id="category_id" name="category_id">
                            <option value="0">Chọn danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Nhập nội dung</label>
                        <textarea name="description" id="editor_edit" class="form-control tinymce_init_selector @error('description') is-invalid @enderror" rows="5">
                        {{ old('description') }}
                        </textarea>
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
