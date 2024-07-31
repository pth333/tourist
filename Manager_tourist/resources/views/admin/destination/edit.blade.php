<!-- Edit Modal -->
<div class="modal fade" id="edit-modal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="BlogModal"></h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('destination.update')}}" id="add-blog-form" name="add-blog-form" class="form-horizontal" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="destinationId" id="destinationId">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập tên địa điểm</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nhập tên địa điểm">
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nhập địa chỉ</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Nhập địa chỉ" >
                            @error('address')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ticket_price" class="col-sm-2 control-label">Giá vé</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control @error('ticket_price') is-invalid @enderror" id="ticket_price" name="ticket_price" placeholder="Nhập giá vé" >
                            @error('ticket_price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="open_time" class="col-sm-2 control-label">Giờ mở cửa</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('open_time') is-invalid @enderror" id="open_time" name="open_time" placeholder="Nhập giờ mở cửa" >
                                    @error('open_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="close_time" class="col-sm-2 control-label">Giờ đóng cửa</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('close_time') is-invalid @enderror" id="close_time" name="close_time" placeholder="Nhập giờ đóng cửa" >
                                    @error('close_time')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="col-sm-2 control-label">Vĩ độ</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" placeholder="Nhập vĩ độ" >
                                    @error('latitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longtitude" class="col-sm-2 control-label">Kinh độ</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control @error('longtitude') is-invalid @enderror" id="longtitude" name="longtitude" placeholder="Nhập kinh độ" >
                                    @error('longtitude')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
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
                        <select class="form-control form-control-sm" name="category_id" id="category_id">
                            <option value="0">Chọn danh mục cha</option>
                            {!! $htmlOption !!}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="description">Nhập nội dung</label>
                        <textarea name="description" id="editor_edit" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save">Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Edit Modal -->
